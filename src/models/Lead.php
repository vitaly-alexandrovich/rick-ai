<?php namespace rickai\models;

class Lead implements TransactionModelInterface {
    /**
     * @var string Уникальный идентификатор пользователя/контакта в вашей CRM или базе данных
     */
    public $user_id;

    /**
     * @var string Уникальный идентификатор браузера пользователя в Google Analytics
     */
    public $client_id;

    /**
     * @var integer Время регистрации. Если параметр не задан, используется текущее время.
     */
    public $lead_created_at;

    /**
     * @var boolean Тип лида: cтарый или новый лид. Rick отправляет событие о получении лида в Google Analytics в виде события ga:eventAction = new lead при параметре new_lead = true или ga:eventAction = old lead при new_lead = false (необязательно)
     */
    public $new_lead;

    /**
     * Метод для более простого создания новой модели лида.
     *
     * @param $user_id
     * @param string $client_id
     * @param bool $new_lead
     * @param null $lead_created_at
     * @return static
     */
    public static function create($user_id, $client_id = '', $new_lead = true, $lead_created_at = null)
    {
        $lead = new static();
        $lead->user_id = $user_id;
        $lead->client_id = $client_id;
        $lead->new_lead = $new_lead;
        $lead->lead_created_at = $lead_created_at === null ? time() : $lead_created_at;

        return $lead;
    }
}