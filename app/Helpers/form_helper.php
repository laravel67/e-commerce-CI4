<?php
if (!function_exists('form_input')) {
    /**
     * Custom Input Form
     *
     * @param string $name       Nama input
     * @param string $value      Nilai default input
     * @param string $errors     Pesan error jika ada
     * @param string $type       Tipe input (default: text)
     * @param string $ph         Placeholder untuk input
     * @param string $title      Label untuk input
     * @param array  $attributes Atribut tambahan untuk input
     * @return string
     */
    function form_input(
        string $name = '',
        string $value = '',
        string $errors = '',
        string $type = 'text',
        string $ph = '',
        string $title = '',
        string $cls = '',
        array $attributes = []
    ): string {
        $attrString = '';
        foreach ($attributes as $key => $val) {
            $attrString .= $key . '="' . htmlspecialchars($val, ENT_QUOTES) . '" ';
        }
        $errorClass = $errors ? 'is-invalid' : '';
        return '
            <div class="form-group">
                <label for="' . htmlspecialchars($name, ENT_QUOTES) . '">' . htmlspecialchars($title, ENT_QUOTES) . '</label>
                <input type="' . htmlspecialchars($type, ENT_QUOTES) . '" 
                       class="form-control rounded-0 ' . $errorClass . '" 
                       id="' . htmlspecialchars($name, ENT_QUOTES) . '" 
                       name="' . htmlspecialchars($name, ENT_QUOTES) . '" 
                       placeholder="' . htmlspecialchars($ph, ENT_QUOTES) . '" 
                       value="' . htmlspecialchars(old($name, $value), ENT_QUOTES) . '" 
                       ' . $attrString . '/>
                ' . ($errors ? '<small class="form-text text-danger">' . htmlspecialchars($errors, ENT_QUOTES) . '</small>' : '') . '
            </div>
        ';
    }
}


if (!function_exists('form_select')) {
    /**
     * Generate a dynamic HTML select element
     *
     * @param string $name Nama atribut `name` untuk elemen select
     * @param array $options Pilihan dalam bentuk array ['value' => 'label'] atau [['value' => ..., 'label' => ...]]
     * @param mixed $selected Nilai yang dipilih (opsional)
     * @param string $title Label untuk select element
     * @param string $errors Pesan error jika ada
     * @param array $attributes Atribut tambahan untuk elemen select (opsional)
     * @return string HTML select element
     */
    function form_select(
        string $name = '',
        array $options = [],
        string $selected = '',
        string $title = '',
        string $errors = '',
        array $attributes = []
    ): string {
        // Generate additional attributes string
        $attrString = '';
        foreach ($attributes as $key => $val) {
            $attrString .= htmlspecialchars($key, ENT_QUOTES) . '="' . htmlspecialchars($val, ENT_QUOTES) . '" ';
        }

        // Error class for invalid input
        $errorClass = $errors ? 'is-invalid' : '';

        // Start building the select HTML
        $html = '
            <div class="form-group">
                <label for="' . htmlspecialchars($name, ENT_QUOTES) . '">' . htmlspecialchars($title, ENT_QUOTES) . '</label>
                <select 
                    class="form-control ' . $errorClass . '" 
                    id="' . htmlspecialchars($name, ENT_QUOTES) . '" 
                    name="' . htmlspecialchars($name, ENT_QUOTES) . '" 
                    ' . $attrString . '>
                    <option value="">Pilih ' . htmlspecialchars($title, ENT_QUOTES) . '</option>
        ';

        // Populate options dynamically
        foreach ($options as $key => $option) {
            // Handle both simple and complex option structures
            $value = is_array($option) ? $option['value'] : $key;
            $label = is_array($option) ? $option['label'] : $option;
            $isSelected = ($value == $selected) ? 'selected' : '';
            $html .= '<option value="' . htmlspecialchars($value, ENT_QUOTES) . '" ' . $isSelected . '>' . htmlspecialchars($label, ENT_QUOTES) . '</option>';
        }

        // Close the select tag
        $html .= '</select>';

        // Add error message if exists
        if ($errors) {
            $html .= '<small class="form-text text-danger">' . htmlspecialchars($errors, ENT_QUOTES) . '</small>';
        }

        // Close the form group
        $html .= '</div>';

        return $html;
    }
}


if (!function_exists('form_text')) {
    /**
     * Custom Input Form
     *
     * @param string $name       Nama input
     * @param string $value      Nilai default input
     * @param string $errors     Pesan error jika ada
     * @param string $type       Tipe input (default: text)
     * @param string $ph         Placeholder untuk input
     * @param string $title      Label untuk input
     * @param array  $attributes Atribut tambahan untuk input
     * @return string
     */
    function form_text(
        string $name = '',
        string $value = '',
        string $errors = '',
        // string $type = 'text',
        string $ph = '',
        string $title = '',
        array $attributes = []
    ): string {
        // Menyusun atribut tambahan
        $attrString = '';
        foreach ($attributes as $key => $val) {
            $attrString .= $key . '="' . htmlspecialchars($val, ENT_QUOTES) . '" ';
        }

        // Menentukan kelas error
        $errorClass = $errors ? 'is-invalid' : '';
        return '
            <div class="form-group">
                <label for="' . htmlspecialchars($name, ENT_QUOTES) . '">' . htmlspecialchars($title, ENT_QUOTES) . '</label>
                <textarea rows="5" 
                       class="form-control ' . $errorClass . '" 
                       id="' . htmlspecialchars($name, ENT_QUOTES) . '" 
                       name="' . htmlspecialchars($name, ENT_QUOTES) . '" 
                       placeholder="' . htmlspecialchars($ph, ENT_QUOTES) . '" 
                       value="' . htmlspecialchars(old($name, $value), ENT_QUOTES) . '" 
                       ' . $attrString . '>' . $value . ' </textarea>
                ' . ($errors ? '<small class="form-text text-danger">' . htmlspecialchars($errors, ENT_QUOTES) . '</small>' : '') . '
            </div>
        ';
    }
}
if (!function_exists('form_radio')) {
    /**
     * Generate a radio input group with options
     *
     * @param string $errors Error message to display
     * @param string $title Title or label for the group
     * @param array $options Array of radio options (name, id, value, title_option)
     * @param mixed $selected Value of the selected option (for checking "checked" state)
     * @return string Rendered HTML for the radio group
     */
    function form_radio(
        string $errors = '',
        string $title = '',
        array $options = [],
        string $selected = '' // Added $selected to handle the old value
    ): string {
        $html = '<div class="form-group mb-3">';
        $html .= '<label>' . htmlspecialchars($title, ENT_QUOTES) . '</label>';
        $html .= '<div class="form-group d-flex">'; // Container for the radio buttons

        foreach ($options as $option) {
            // Check if the current option value is selected
            $isChecked = ($option['value'] == $selected) ? 'checked' : '';

            $html .= '
            <div class="form-check mx-2 my-0 ">
                <label class="form-check-label">
                    <input 
                        type="radio" 
                        name="' . htmlspecialchars($option['name'], ENT_QUOTES) . '" 
                        id="' . htmlspecialchars($option['id'], ENT_QUOTES) . '" 
                        class="form-check-input" 
                        value="' . htmlspecialchars($option['value'], ENT_QUOTES) . '" 
                        ' . $isChecked . '
                    >
                    ' . htmlspecialchars($option['title_option'], ENT_QUOTES) . '
                    <i class="input-helper"></i>
                </label>
            </div>';
        }

        $html .= '</div>'; // Close the container

        // Display error message if any
        if ($errors) {
            $html .= '<small class="form-text text-danger">' . htmlspecialchars($errors, ENT_QUOTES) . '</small>';
        }

        $html .= '</div>';

        return $html;
    }
}


if (!function_exists('btn_auth')) {
    function btn_auth(
        string $title = '',
    ) {
        return '
        <button style="background-color:#7fad39;" type="submit" class="btn-auth btn rounded-0 col-12 mt-3"><strong class="text-white">' . $title . '</strong></button>
        ';
    }
}

if (!function_exists('btn_submit')) {
    function btn_submit(
        string $href = '#',
        array $attributes = []
    ): string {
        return '
        <div class="float-right">
            <a href="' . $href . '" class="btn btn-danger">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
        ';
    }
}
