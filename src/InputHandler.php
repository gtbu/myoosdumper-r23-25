<?php
/**
 * ---------------------------------------------------------------------

   MyOOS [Dumper]
   https://www.oos-shop.de/

   Copyright (c) 2013 - 2024 by the MyOOS Development Team.
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ----------------------------------------------------------------------
 */


namespace SecureInput;

/**
 * Class InputHandler
 *
 * This class handles and sanitizes input data to ensure security.
 *
 * @package SecureInput
 */
class InputHandler
{
    /**
     * @var array The sanitized input data.
     */
    private $data;

    /**
     * InputHandler constructor.
     *
     * @param array $input The input data to be sanitized.
     */
    public function __construct(array $input)
    {
        $this->data = $this->sanitize($input);
    }

    /**
     * Sanitize the input data.
     *
     * @param array $input The input data to be sanitized.
     * @return array The sanitized input data.
     */
    private function sanitize(array $input): array
    {
        $sanitized = [];
        foreach ($input as $key => $value) {
            $sanitized[$this->sanitizeKey($key)] = $this->sanitizeValue($value);
        }
        return $sanitized;
    }

    /**
     * Sanitize a key.
     *
     * @param string $key The key to be sanitized.
     * @return string The sanitized key.
     */
    private function sanitizeKey(string $key): string
    {
        return preg_replace('/[^a-zA-Z0-9_]/', '', $key);
    }

    /**
     * Sanitize a value.
     *
     * @param mixed $value The value to be sanitized.
     * @return mixed The sanitized value.
     */
    private function sanitizeValue($value)
    {
        if (is_array($value)) {
            return array_map([$this, 'sanitizeValue'], $value);
        }
        return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    /**
     * Get a sanitized value by key.
     *
     * @param string $key The key of the value to retrieve.
     * @param mixed $default The default value to return if the key does not exist.
     * @return mixed The sanitized value or the default value.
     */
    public function get(string $key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }
}
