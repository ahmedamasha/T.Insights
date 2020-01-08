<?php

namespace App\Core\Request;

use App\Core\Contracts\RequestInterface;
use Illuminate\Support\Facades\Validator;
use ReflectionMethod;
use RuntimeException;
use Tajawal\Nitro\Exceptions\BadRequestException;


/**
 * Class Request
 *
 * @package App\Core\Base
 * @property $errors
 * @property $attributes
 *
 */
abstract class Request implements RequestInterface
{
    /**
     * @var array error messages
     */
    protected $messages = [];

    /**
     * @var array error list
     */
    protected $errors = [];

    /**
     * @var array attributes list
     */
    protected $attributes = [];

    /** @var array filters list */
    protected $filters = [];

    /**
     * @param array $data data array
     *
     * @return $this
     */
    public function load(array $data)
    {
        $attributes = $this->attributes();

        foreach ($attributes as $attribute) {
            if (isset($data[$attribute])) {
                $this->attributes[$attribute] = $data[$attribute];
            } else {
                $this->attributes[$attribute] = null;
            }
        }

        return $this;
    }

    /**
     * DESC
     *
     * @return $this
     *
     * @author Ahmed Amasha <ahmed.amasha@tajawal.com>
     *
     */
    public function validate()
    {
        //skip validation if rules are empty
        if (empty($this->rules())) {
            return $this;
        }

        $data = $this->getAttributes();

        // Make a new validator object
        $validator = Validator::make($data, $this->rules(), $this->messages());

        // Check for failure
        if ($validator->fails()) {
            $this->errorBadRequest($validator->errors());
        }

        return $this;
    }

    /**
     * The exception is automatically caught by the handler and JSON is returned
     *
     * @param string $detail
     * @param string $title
     *
     * @throws \Tajawal\Nitro\Exceptions\BadRequestException
     *
     * @author Ahmed Amasha <ahmed.amasha@tajawal.com>
     *
     */
    public function errorBadRequest($detail = '', $title = '')
    {
        throw new BadRequestException($detail, $title);
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     *
     * @return $this
     */
    public function setAttributes(array $attributes)
    {
        foreach ($attributes as $attribute => $value) {
            $this->setAttribute($attribute, $value);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return $this->messages;
    }

    /**
     * @param  string $attribute attribute
     * @param   mixed $value     value
     *
     * @return $this
     */
    public function setAttribute(string $attribute, $value)
    {
        if (in_array($attribute, $this->attributes())) {
            $this->attributes[$attribute] = $value;
        }

        return $this;
    }

    /**
     * @param string $attribute attribute name
     *
     * @return mixed|null
     */
    public function getAttribute(string $attribute)
    {
        $value = $this->attributes[$attribute] ?? null;

        return $value;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->attributes;
    }

    /**
     * @param string $property property name
     *
     * @return mixed
     */
    public function __get(string $property)
    {
        $method = 'get' . ucfirst($property); // camelCase() method name

        if (method_exists($this, $method)) {
            $reflection = new ReflectionMethod($this, $method);
            if (!$reflection->isPublic()) {
                throw new RuntimeException("The called method is not public");
            }
        }

        if (in_array($property, $this->attributes())) {
            return $this->attributes[$property];
        }
    }

    /**
     * @param string $property property name
     * @param mixed  $value    value
     *
     * @return $this
     */
    public function __set(string $property, $value)
    {
        $method = 'set' . ucfirst($property); // camelCase() method name

        if (method_exists($this, $method)) {
            $reflection = new ReflectionMethod($this, $method);
            if (!$reflection->isPublic()) {
                throw new RuntimeException("The called method is not public");
            }
        }

        if (in_array($property, $this->attributes())) {
            $this->attributes[$property] = $value;
        }

        return $this;
    }

    /**
     * @param string $property property name
     *
     * @return bool
     */
    public function __isset(string $property)
    {
        return isset($this->attributes[$property]);
    }

    /**
     * @param string $error
     *
     * @return $this
     */
    public function addError(string $error)
    {
        $this->errors[] = $error;

        return $this;
    }

    /**
     * sanitize the all input data
     *
     * @param array $attributes
     *
     * @return array
     * @author Ahmed Amasha  <ahmed.amasha@tajawal.com>
     */
    public function sanitizeModelData(array $attributes): array
    {
        $sanitizedInputs = $this->sanitizeAllData(function ($item) {
            return trim(strip_tags($item));
        }, $attributes);

        return $sanitizedInputs;
    }

    /**
     * function to sanitize all data
     *
     * @param $callback
     * @param $array
     *
     * @return array
     *
     * @author Ahmed Amasha <ahmed.amasha@tajawal.com>
     *
     */
    public function sanitizeAllData($callback, $array): array
    {
        $func = function ($item) use (&$func, &$callback) {
            return is_array($item) ? array_map($func, $item) : call_user_func($callback, $item);
        };

        return array_map($func, $array);
    }
}
