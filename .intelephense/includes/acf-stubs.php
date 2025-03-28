<?php
if (!function_exists('get_field')) {
    /**
     * Retrieves the value of a custom field.
     *
     * @param string $key
     * @param mixed $post_id
     * @param bool $format_value
     * @return mixed
     */
    function get_field(string $key, $post_id = false, bool $format_value = true) {
        return null;
    }
}

if (!function_exists('the_field')) {
    /**
     * Displays the value of a custom field.
     *
     * @param string $key
     * @param mixed $post_id
     * @param bool $format_value
     */
    function the_field(string $key, $post_id = false, bool $format_value = true) {}
}

if (!function_exists('have_rows')) {
    /**
     * Checks if a repeater field has rows.
     *
     * @param string $key
     * @param mixed $post_id
     * @return bool
     */
    function have_rows(string $key, $post_id = false): bool {
        return false;
    }
}

if (!function_exists('get_row')) {
    /**
     * Retrieves the current row data for a repeater field.
     *
     * @return array|null
     */
    function get_row(): ?array {
        return null;
    }
}

if (!function_exists('the_row')) {
    /**
     * Moves the repeater field loop to the next row.
     */
    function the_row() {}
}

if (!function_exists('get_sub_field')) {
    /**
     * Retrieves the value of a sub field inside a repeater.
     *
     * @param string $key
     * @return mixed
     */
    function get_sub_field(string $key) {
        return null;
    }
}

if (!function_exists('the_sub_field')) {
    /**
     * Displays the value of a sub field inside a repeater.
     *
     * @param string $key
     */
    function the_sub_field(string $key) {}
}

if (!function_exists('get_field_object')) {
    /**
     * Retrieves the field object for a specific field key.
     *
     * @param string $key
     * @param mixed $post_id
     * @param bool $format_value
     * @return array|null
     */
    function get_field_object(string $key, $post_id = false, bool $format_value = true): ?array {
        return null;
    }
}

if (!function_exists('get_sub_field_object')) {
    /**
     * Retrieves the sub field object for a specific field key inside a repeater.
     *
     * @param string $key
     * @return array|null
     */
    function get_sub_field_object(string $key): ?array {
        return null;
    }
}

if (!function_exists('update_field')) {
    /**
     * Updates the value of a custom field.
     *
     * @param string $key
     * @param mixed $value
     * @param mixed $post_id
     * @return bool
     */
    function update_field(string $key, $value, $post_id = false): bool {
        return true;
    }
}

if (!function_exists('update_sub_field')) {
    /**
     * Updates the value of a sub field inside a repeater.
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    function update_sub_field(string $key, $value): bool {
        return true;
    }
}

if (!function_exists('delete_field')) {
    /**
     * Deletes a custom field.
     *
     * @param string $key
     * @param mixed $post_id
     * @return bool
     */
    function delete_field(string $key, $post_id = false): bool {
        return true;
    }
}

if (!function_exists('delete_sub_field')) {
    /**
     * Deletes a sub field inside a repeater.
     *
     * @param string $key
     * @return bool
     */
    function delete_sub_field(string $key): bool {
        return true;
    }
}

if (!function_exists('get_row_index')) {
    /**
     * Gets the current row index in a repeater field.
     *
     * @return int|null
     */
    function get_row_index(): ?int {
        return null;
    }
}

if (!function_exists('get_row_sub_field')) {
    /**
     * Retrieves the value of a sub field in a repeater field at a specific row index.
     *
     * @param string $field_name
     * @param int $row_index
     * @param bool $format_value
     * @return mixed
     */
    function get_row_sub_field(string $field_name, int $row_index, bool $format_value = true) {
        return null;
    }
}

if (!function_exists('acf_add_local_field_group')) {
    /**
     * Registers a field group programmatically.
     *
     * @param array $field_group
     * @return void
     */
    function acf_add_local_field_group(array $field_group) {}
}

if (!function_exists('acf_add_local_field')) {
    /**
     * Registers a field programmatically.
     *
     * @param array $field
     * @return void
     */
    function acf_add_local_field(array $field) {}
}

if (!function_exists('acf_register_block_type')) {
    /**
     * Registers a custom ACF block.
     *
     * @param array $block
     * @return void
     */
    function acf_register_block_type(array $block) {}
}

if (!function_exists('acf_maybe_get_field')) {
    /**
     * Retrieves a field object without triggering errors.
     *
     * @param string $key
     * @param mixed $post_id
     * @param bool $format_value
     * @return array|null
     */
    function acf_maybe_get_field(string $key, $post_id = false, bool $format_value = true): ?array {
        return null;
    }
}

if (!function_exists('acf_get_field')) {
    /**
     * Retrieves a field object.
     *
     * @param string $key
     * @return array|null
     */
    function acf_get_field(string $key): ?array {
        return null;
    }
}
?>