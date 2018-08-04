<?php

namespace AdamwjtkProductBundle\Service\Core;


interface IResponse
{
    const ProductCreated = 'utworzono nowy produkt';
    const ProductCreatedFalse = 'nie udało się utworzyć nowego produktu';

    const ProductEdited = 'zmieniono produkt';
    const ProductEditedFalse = 'nie udało się zmienić produktu';

    const ProductDeleted = 'usunięto produkt';
    const ProductDeletedFalse = 'nie udało się usunąć produktu';

    const ProductList = 'Lista produktów';
    const ProductListFalse = 'nie udało się zrwócić listy produktów';
    const ProductListAmountEquals = 'Lista produktów z ilością równą ';
    const ProductListAmountMoreThan = 'Lista produktów z ilością większą od ';
    const ProductListAmountLowerThan = 'Lista produktów z ilością mniejszą niż ';

    const ProductGetById = 'ok';
    const ProductGetByIdFalse = 'nie znaleziono produktu';
}