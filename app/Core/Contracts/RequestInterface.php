<?php

namespace App\Core\Contracts;

/**
 * Interface RequestInterface
 *
 * @package App\Core\Contracts
 * @author  Ahmed Amasha <ahmed.amasha@tajawal.com>
 *
 */
interface RequestInterface
{
    /**
     * @return array
     */
    public function attributes(): array;

    /**
     * @return array
     */
    public function getAttributes(): array;

    /**
     * @param string $attribute attribute name
     *
     * @return mixed
     */
    public function getAttribute(string $attribute);

    /**
     * @param string $attribute attribute
     * @param mixed  $value     value
     *
     * @return mixed
     */
    public function setAttribute(string $attribute, $value);

    /**
     * @param array $attributes attribute
     *
     * @return mixed
     */
    public function setAttributes(array $attributes);

    /**
     * @return bool
     */
    public function validate();

    /**
     * @return array
     */
    public function rules(): array;

    /**
     * @return array
     */
    public function messages(): array;

    /**
     * @param array $data data array
     *
     * @return mixed
     */
    public function load(array $data);

    /**
     * @return mixed
     */
    public function process();

    /**
     * @return array
     */
    public function toArray(): array;
}
