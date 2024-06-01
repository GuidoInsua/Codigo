<?php

interface jsonDeserializable {
    public static function jsonDeserialize(array $json): self;
}

?>