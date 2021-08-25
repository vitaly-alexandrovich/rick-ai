<?php namespace rickai;

use HttpClient\Client as HttpClient;
use HttpClient\Request;
use rickai\models\Lead;
use rickai\models\Transaction;
use rickai\models\TransactionModelInterface;

class Client
{
    const TRANSACTIONS_ENDPOINT = 'https://exchange.rick.ai/transactions';

    private $company;

    public function __construct($company)
    {
        $this->company = $company;
    }

    protected function createEndpoint($method) {
        return sprintf('%s/%s/%s', static::TRANSACTIONS_ENDPOINT, $this->company, $method);
    }


    protected static function preparedTransaction(Transaction $transaction)
    {
        $transaction->items = array_map(function ($item) {
            $item->sku = strval($item->sku);
            $item->price = floatval($item->price);

            return array_filter((array) $item, function ($prop) {
                return !is_null($prop);
            });
        }, $transaction->items);

        $transaction->transaction_id = strval($transaction->transaction_id);
        $transaction->user_id = strval($transaction->user_id);
        $transaction->client_id = strval($transaction->client_id);

        if ($transaction->client_id == '.') {
            $transaction->client_id = '';
        }

        return array_filter((array) $transaction, function ($prop) {
            return !is_null($prop);
        });
    }

    /**
     * Выполняет запрос к rick.ai
     *
     * @param $method
     * @param Transaction $transaction
     * @return bool
     */
    protected function request($method, TransactionModelInterface $transaction) {
        $client = new HttpClient();

        $request = new Request($this->createEndpoint($method));
        $request->setMethod(Request::POST_METHOD);
        $request->setData(json_encode(static::preparedTransaction($transaction), JSON_PRETTY_PRINT));
        $request->setHeaders([
            'Content-Type' => 'application/json'
        ]);

        return $client->sendRequest($request)->getCode() == 200;
    }

    /**
     * Оправляет данные о новом заказе в rick.ai
     *
     * @param Transaction $transaction
     * @return bool
     */
    public function create(Transaction $transaction)
    {
        return $this->request('create', $transaction);
    }

    /**
     * Обновляет информацию о заказе в rick.ai
     *
     * @param Transaction $transaction
     * @return bool
     */
    public function update(Transaction $transaction)
    {
        return $this->request('update', $transaction);
    }

    /**
     * Отправляет информацию о регистрации пользователя в rick.ai
     *
     * @param Lead $lead
     * @return bool
     */
    public function lead(Lead $lead)
    {
        return $this->request('lead', $lead);
    }
}