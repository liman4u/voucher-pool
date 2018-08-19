<?php

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use PHPUnit\Framework\Assert as PHPUnit;

abstract class TestCase extends Laravel\Lumen\Testing\TestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }


    /**
    * Modified this method contains in MakesHttpRequests class to allow to pass json fragment correctly
    * Helpful Link: https://github.com/laravel/framework/issues/11068
    *
    * Assert that the response contains the given JSON.
    *
    * @param  array  $data
    * @param  bool  $negate
    * @return $this
    */
    protected function seeJsonContains(array $data, $negate = false)
    {
        $method = $negate ? 'assertFalse' : 'assertTrue';

        $actual = json_decode($this->response->getContent(), true);

        if (is_null($actual) || $actual === false) {
            return PHPUnit::fail('Invalid JSON was returned from the route. Perhaps an exception was thrown?');
        }

        $actual = json_encode(array_sort_recursive(
            (array) $actual
        ));

        foreach (array_sort_recursive($data) as $key => $value) {
            $expected = $this->formatToExpectedJson($key, $value);

            if (is_array($value)) {
                $this->seeJsonContains($value, $negate);
                continue;
            }

            PHPUnit::{$method}(
                Str::contains($actual, $expected),
                ($negate ? 'Found unexpected' : 'Unable to find')." JSON fragment [{$expected}] within [{$actual}]."
            );
        }

        return $this;
    }
}
