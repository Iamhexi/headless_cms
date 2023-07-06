<?php

interface Token {
    function getToken(): string;
    function isValid(): bool;
}