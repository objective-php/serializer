<?php
/**
 * Created by PhpStorm.
 * User: Neofox
 * Date: 13/06/2016
 * Time: 12:33
 */

namespace Serializer\Schema;


interface SchemaInterface
{

    public function transform($data) : array;
}