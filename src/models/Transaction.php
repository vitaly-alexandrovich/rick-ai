<?php namespace rickai\models;

class Transaction implements TransactionModelInterface {
    const CURRENCY_RUB = 'RUB';
    const CURRENCY_USD = 'USD';
    const CURRENCY_EUR = 'EUR';
    const CURRENCY_GBP = 'GBP';

    const DS_WEBSITE = 'website';
    const DS_APPLICATION = 'IOS';

    /**
     * @var string Уникальный идентификатор пользователя/контакта в вашей CRM или базе данных
     */
    public $user_id;

    /**
     * @var string Уникальный идентификатор браузера пользователя в Google Analytics
     */
    public $client_id;

    /**
     * @var string Уникальный идентификатор транзакции в CRM
     */
    public $transaction_id;

    /**
     * @var integer Время создания сделки в формате UNIX, всегда считается по UTC +0 (обязательный параметр при создании транзакции)
     */
    public $deal_created_at;

    /**
     * @var integer Время изменения сделки в формате UNIX, всегда считается по UTC +0 (обязательный параметр при обновлении транзакции)
     */
    public $deal_updated_at;

    /**
     * @var string Статус заказа - который получает заказ при создании и обновлении у вас в CRM или базе данных.
     */
    public $status;

    /**
     * @var string Идентификатор вашего приложения в Rick, который определяет, в какой счетчик GA отправить транзакцию.
     */
    public $data_source = self::DS_WEBSITE;

    /**
     * @var float Сумма заказа - равна сумме заказа, которую вы видите у себя в CRM или базе данных при создании заказа.
     */
    public $revenue;

    /**
     * @var boolean Отправьте true, если заказ создан, когда пользователя нет на сайте: например, регулярная оплата подписки списана с карты (необязательно)
     */
    public $offline;

    /**
     * @var Item[] Список услуг в сделке
     */
    public $items;

    /**
     * @var string если заказы приходят с нескольких доменов, укажите название домена из Google Analytics, чтобы транзакции в GA присвоились к нужному домену (необязательно)
     */
    public $hostname;

    /**
     * @var string Ссылка на сделку в CRM, чтобы вы могли перейти из Rick сразу к конкретной сделке в вашей CRM (необязательно)
     */
    public $deal_url;

    /**
     * @var string Маржинальная прибыль от заказа. Обычно считается как выручка-себестоимость, либо по вашей собственной формуле внутри компании (необязательно)
     */
    public $grossprofit;

    /**
     * @var string Валюта, в которой оформлен заказ. Отправляйте валюту, которую хотите увидеть в Рике: RUB, USD, EUR или GBP (необязательно)
     */
    public $currency = self::CURRENCY_RUB;

    /**
     * @var string Источник заказа: телефон, чат, почта, форма и тд. В отчётах сможете выбрать источник заказа и проверить его конверсию (необязательно)
     */
    public $deal_method;

    /**
     * @var string Ответственный менеджер сделки. Можно вывести как группировку в виджетах, чтобы увидеть конверсию по менеджерам в разных каналах (необязательно)
     */
    public $manager;

    /**
     * @var string Причина отказа у сделки. Можно вывести как группировку в виджетах, чтобы увидеть причины отказа по каналам (необязательно)
     */
    public $loss_reason;

    /**
     * @var integer Время регистрации. Если параметр не задан, используется текущее время.
     */
    public $lead_created_at;

    /**
     * @var boolean Тип лида: cтарый или новый лид. Rick отправляет событие о получении лида в Google Analytics в виде события ga:eventAction = new lead при параметре new_lead = true или ga:eventAction = old lead при new_lead = false (необязательно)
     */
    public $new_lead;

    /**
     * Добавляет элемент корзины
     */
    public function addItem(Item $item) {
        $this->items[] = $item;
        return $this;
    }
}