<?php namespace rickai\models;

class Item {
    /**
     * @var string Название услуги в вашей CRM или базе данных
     */
    public $name;

    /**
     * @var string Артикул, SKU или код услуги в вашей CRM или базе данных, другими словами уникальный идентификатор услуги (необязательно)
     */
    public $sku;

    /**
     * @var float Стоимость одной услуги с учётом всех скидок - то есть именно там сумма, которую заплатил покупатель
     */
    public $price;

    /**
     * @var integer Количество единиц услуг в заказе в штуках
     */
    public $quantity;

    /**
     * @var string Категория услуги в вашей CRM или базе данных. Если у услуги несколько вложенных категорий, используйте / как разделитель (необязательно)
     */
    public $category;

    /**
     * @var string Купон или промокод на скидку. Можно вывести как группировку в виджета, чтобы увидеть количество заказов с использованием промокода. (необязательно)
     */
    public $coupon;
}