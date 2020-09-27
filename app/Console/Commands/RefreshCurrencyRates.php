<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\DTO\CentralBankCurrency;
use App\Exceptions\CurrenciesCouldNotBeLoaded;
use Throwable;

/**
 * Команда выполняет запрос к ЦБ РФ и обновляет курсы валют, сохраняя их в таблицу currency_rates.
 * Выполняется по расписанию, ежедневно.
 * @see App\Console\Kernel::schedule()
 * @package App\Console\Commands
 */
class RefreshCurrencyRates extends Command
{
    const RUB_CODE = 'RUB';
    const PRECISION = 6;

    /** @var array */
    private array $loadedRates = [];

    /** @var int */
    private int $updatedRowsCount = 0;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Loads currency rates from Central Bank of Russia';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $this->fetchRates();
            $this->store();
            $this->info(sprintf('Rates updated (%s rows)', $this->updatedRowsCount));
            return 0;
        } catch (CurrenciesCouldNotBeLoaded $e) {
            $this->error($e->getMessage());
            return 1;
        } catch (Throwable $e) {
            $this->error(sprintf('Unexpected error [%s]: %s', get_class($e), $e->getMessage()));
            return 2;
        }
    }

    private function fetchRates(): void
    {
        $this->loadedRates = [];
        $rates = simplexml_load_file($this->source());
        if ($rates === false) {
            throw new CurrenciesCouldNotBeLoaded('Cannot load data from Central Bank of Russia');
        }

        foreach ($rates->Valute as $node) {
            $currency = CentralBankCurrency::createFromXml($node);

            $rate = round($currency->nominal / $currency->value, self::PRECISION);
            $reverseRate = round($currency->value / $currency->nominal, self::PRECISION);

            $this->loadedRates[] = [self::RUB_CODE, $currency->code, $rate];
            $this->loadedRates[] = [$currency->code, self::RUB_CODE, $reverseRate];
        }

        if (empty($this->loadedRates)) {
            throw new CurrenciesCouldNotBeLoaded('Central Bank of Russia gives empty response');
        }
    }

    private function store(): void
    {
        DB::transaction(function () {
            DB::table('currency_rates')->truncate();
            foreach ($this->loadedRates as $row) {
                DB::insert('insert into currency_rates (currency_from, currency_to, rate) values (?, ?, ?)', $row);
                $this->updatedRowsCount++;
            }
        });
    }

    private function source(): string
    {
        return sprintf('https://www.cbr.ru/scripts/XML_daily.asp?date_req=%s', date('d/m/Y'));
    }
}
