<?php

namespace core\Twig;

use \Twig_Extension;

class Core_Twig_Extension extends Twig_Extension {

    private $CI;

    /**
     * List of all benchmark markers and when they were added
     *
     * @var array
     */
    var $marker = array();

    public function __construct() {
        $this->CI = & get_instance();
    }

    public function getGlobals() {
        return array(
            'app' => array(
                "input" => $this->CI->input
            )
        );
    }

    public function getFunctions() {
        return array(
            new \Twig_SimpleFunction('elapsed_time', array($this, 'elapsed_time'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('anchor', array($this, 'anchor'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('site_url', array($this, 'site_url'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('form_button', array($this, 'form_button'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('form_checkbox', array($this, 'form_checkbox'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('form_close', array($this, 'form_close'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('form_dropdown', array($this, 'form_dropdown'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('form_error', array($this, 'form_error'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('form_fieldset', array($this, 'form_fieldset'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('form_fieldset_close', array($this, 'form_fieldset_close'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('form_input', array($this, 'form_input'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('form_hidden', array($this, 'form_hidden'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('form_label', array($this, 'form_label'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('form_multiselect', array($this, 'form_multiselect'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('form_open', array($this, 'form_open'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('form_open_multipart', array($this, 'form_open_multipart'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('form_password', array($this, 'form_password'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('form_prep', array($this, 'form_prep'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('form_radio', array($this, 'form_radio'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('form_reset', array($this, 'form_reset'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('form_submit', array($this, 'form_submit'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('form_textarea', array($this, 'form_textarea'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('form_upload', array($this, 'form_upload'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('set_checkbox', array($this, 'set_checkbox'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('set_radio', array($this, 'set_radio'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('set_select', array($this, 'set_select'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('set_value', array($this, 'set_value'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('validation_errors', array($this, 'validation_errors'), array('is_safe' => array('html'))),
            new \Twig_SimpleFunction('base_url', array($this, 'base_url'), array('is_safe' => array('html')))
        );
    }

    public function base_url($uri = '') {
        return $this->CI->config->base_url($uri);
    }

    public function elapsed_time($point1 = '', $point2 = '', $decimals = 6) {
        $time = microtime(true);
        $start = $time;

        $time = microtime(true);
        $finish = $time;
        $total_time = number_format($finish - $start, $decimals);
        return $total_time;
    }

    public function anchor($uri = '', $title = '', $attributes = '') {
        $title = (string) $title;

        if (!is_array($uri)) {
            $site_url = (!preg_match('!^\w+://! i', $uri)) ? $this->site_url($uri) : $uri;
        } else {
            $site_url = $this->site_url($uri);
        }

        if ($title == '') {
            $title = $site_url;
        }

        if ($attributes != '') {
            $attributes = $this->_parse_attributes($attributes);
        }

        return '<a href="' . $site_url . '"' . $attributes . '>' . $title . '</a>';
    }

    public function site_url($uri = '') {
        return $this->CI->config->site_url($uri);
    }

    public function _parse_attributes($attributes, $javascript = FALSE) {
        if (is_string($attributes)) {
            return ($attributes != '') ? ' ' . $attributes : '';
        }

        $att = '';
        foreach ($attributes as $key => $val) {
            if ($javascript == TRUE) {
                $att .= $key . '=' . $val . ',';
            } else {
                $att .= ' ' . $key . '="' . $val . '"';
            }
        }

        if ($javascript == TRUE AND $att != '') {
            $att = substr($att, 0, -1);
        }

        return $att;
    }

    function &_get_validation_object() {

        // We set this as a variable since we're returning by reference.
        $return = FALSE;

        if (FALSE !== ($object = $this->CI->load->is_loaded('form_validation'))) {
            if (!isset($this->CI->$object) OR !is_object($this->CI->$object)) {
                return $return;
            }

            return $this->CI->$object;
        }

        return $return;
    }

    function _attributes_to_string($attributes, $formtag = FALSE) {
        if (is_string($attributes) AND strlen($attributes) > 0) {
            if ($formtag == TRUE AND strpos($attributes, 'method=') === FALSE) {
                $attributes .= ' method="post"';
            }

            if ($formtag == TRUE AND strpos($attributes, 'accept-charset=') === FALSE) {
                $attributes .= ' accept-charset="' . strtolower(config_item('charset')) . '"';
            }

            return ' ' . $attributes;
        }

        if (is_object($attributes) AND count($attributes) > 0) {
            $attributes = (array) $attributes;
        }

        if (is_array($attributes) AND count($attributes) > 0) {
            $atts = '';

            if (!isset($attributes['method']) AND $formtag === TRUE) {
                $atts .= ' method="post"';
            }

            if (!isset($attributes['accept-charset']) AND $formtag === TRUE) {
                $atts .= ' accept-charset="' . strtolower(config_item('charset')) . '"';
            }

            foreach ($attributes as $key => $val) {
                $atts .= ' ' . $key . '="' . $val . '"';
            }

            return $atts;
        }
    }

    function _parse_form_attributes($attributes, $default) {
        if (is_array($attributes)) {
            foreach ($default as $key => $val) {
                if (isset($attributes[$key])) {
                    $default[$key] = $attributes[$key];
                    unset($attributes[$key]);
                }
            }

            if (count($attributes) > 0) {
                $default = array_merge($default, $attributes);
            }
        }

        $att = '';

        foreach ($default as $key => $val) {
            if ($key == 'value') {
                $val = $this->form_prep($val, $default['name']);
            }

            $att .= $key . '="' . $val . '" ';
        }

        return $att;
    }

    function validation_errors($prefix = '', $suffix = '') {
        if (FALSE === ($OBJ = & $this->_get_validation_object())) {
            return '';
        }

        return $OBJ->error_string($prefix, $suffix);
    }

    function form_error($field = '', $prefix = '', $suffix = '') {
        if (FALSE === ($OBJ = & $this->_get_validation_object())) {
            return '';
        }

        return $OBJ->error($field, $prefix, $suffix);
    }

    function set_radio($field = '', $value = '', $default = FALSE) {
        $OBJ = & $this->_get_validation_object();

        if ($OBJ === FALSE) {
            if (!isset($_POST[$field])) {
                if (count($_POST) === 0 AND $default == TRUE) {
                    return ' checked="checked"';
                }
                return '';
            }

            $field = $_POST[$field];

            if (is_array($field)) {
                if (!in_array($value, $field)) {
                    return '';
                }
            } else {
                if (($field == '' OR $value == '') OR ($field != $value)) {
                    return '';
                }
            }

            return ' checked="checked"';
        }

        return $OBJ->set_radio($field, $value, $default);
    }

    function set_checkbox($field = '', $value = '', $default = FALSE) {
        $OBJ = & $this->_get_validation_object();

        if ($OBJ === FALSE) {
            if (!isset($_POST[$field])) {
                if (count($_POST) === 0 AND $default == TRUE) {
                    return ' checked="checked"';
                }
                return '';
            }

            $field = $_POST[$field];

            if (is_array($field)) {
                if (!in_array($value, $field)) {
                    return '';
                }
            } else {
                if (($field == '' OR $value == '') OR ($field != $value)) {
                    return '';
                }
            }

            return ' checked="checked"';
        }

        return $OBJ->set_checkbox($field, $value, $default);
    }

    function set_select($field = '', $value = '', $default = FALSE) {
        $OBJ = & $this->_get_validation_object();

        if ($OBJ === FALSE) {
            if (!isset($_POST[$field])) {
                if (count($_POST) === 0 AND $default == TRUE) {
                    return ' selected="selected"';
                }
                return '';
            }

            $field = $_POST[$field];

            if (is_array($field)) {
                if (!in_array($value, $field)) {
                    return '';
                }
            } else {
                if (($field == '' OR $value == '') OR ($field != $value)) {
                    return '';
                }
            }

            return ' selected="selected"';
        }

        return $OBJ->set_select($field, $value, $default);
    }

    function set_value($field = '', $default = '') {
        if (FALSE === ($OBJ = & $this->_get_validation_object())) {
            if (!isset($_POST[$field])) {
                return $default;
            }

            return $this->form_prep($_POST[$field], $field);
        }

        return $this->form_prep($OBJ->set_value($field, $default), $field);
    }

    function form_prep($str = '', $field_name = '') {
        static $prepped_fields = array();

        // if the field name is an array we do this recursively
        if (is_array($str)) {
            foreach ($str as $key => $val) {
                $str[$key] = form_prep($val);
            }

            return $str;
        }

        if ($str === '') {
            return '';
        }

        // we've already prepped a field with this name
        // @todo need to figure out a way to namespace this so
        // that we know the *exact* field and not just one with
        // the same name
        if (isset($prepped_fields[$field_name])) {
            return $str;
        }

        $str = htmlspecialchars($str);

        // In case htmlspecialchars misses these.
        $str = str_replace(array("'", '"'), array("&#39;", "&quot;"), $str);

        if ($field_name != '') {
            $prepped_fields[$field_name] = $field_name;
        }

        return $str;
    }

    function form_close($extra = '') {
        return "</form>" . $extra;
    }

    function form_fieldset_close($extra = '') {
        return "</fieldset>" . $extra;
    }

    function form_fieldset($legend_text = '', $attributes = array()) {
        $fieldset = "<fieldset";

        $fieldset .= $this->_attributes_to_string($attributes, FALSE);

        $fieldset .= ">\n";

        if ($legend_text != '') {
            $fieldset .= "<legend>$legend_text</legend>\n";
        }

        return $fieldset;
    }

    function form_label($label_text = '', $id = '', $attributes = array()) {

        $label = '<label';

        if ($id != '') {
            $label .= " for=\"$id\"";
        }

        if (is_array($attributes) AND count($attributes) > 0) {
            foreach ($attributes as $key => $val) {
                $label .= ' ' . $key . '="' . $val . '"';
            }
        }

        $label .= ">$label_text</label>";

        return $label;
    }

    function form_button($data = '', $content = '', $extra = '') {
        $defaults = array('name' => ((!is_array($data)) ? $data : ''), 'type' => 'button');

        if (is_array($data) AND isset($data['content'])) {
            $content = $data['content'];
            unset($data['content']); // content is not an attribute
        }

        return "<button " . $this->_parse_form_attributes($data, $defaults) . $extra . ">" . $content . "</button>";
    }

    function form_reset($data = '', $value = '', $extra = '') {
        $defaults = array('type' => 'reset', 'name' => ((!is_array($data)) ? $data : ''), 'value' => $value);

        return "<input " . $this->_parse_form_attributes($data, $defaults) . $extra . " />";
    }

    function form_submit($data = '', $value = '', $extra = '') {
        $defaults = array('type' => 'submit', 'name' => ((!is_array($data)) ? $data : ''), 'value' => $value);

        return "<input " . $this->_parse_form_attributes($data, $defaults) . $extra . " />";
    }

    function form_radio($data = '', $value = '', $checked = FALSE, $extra = '') {
        if (!is_array($data)) {
            $data = array('name' => $data);
        }

        $data['type'] = 'radio';
        return $this->form_checkbox($data, $value, $checked, $extra);
    }

    function form_checkbox($data = '', $value = '', $checked = FALSE, $extra = '') {
        $defaults = array('type' => 'checkbox', 'name' => ((!is_array($data)) ? $data : ''), 'value' => $value);

        if (is_array($data) AND array_key_exists('checked', $data)) {
            $checked = $data['checked'];

            if ($checked == FALSE) {
                unset($data['checked']);
            } else {
                $data['checked'] = 'checked';
            }
        }

        if ($checked == TRUE) {
            $defaults['checked'] = 'checked';
        } else {
            unset($defaults['checked']);
        }

        return "<input " . $this->_parse_form_attributes($data, $defaults) . $extra . " />";
    }

    function form_dropdown($name = '', $options = array(), $selected = array(), $extra = '') {
        if (!is_array($selected)) {
            $selected = array($selected);
        }

        // If no selected state was submitted we will attempt to set it automatically
        if (count($selected) === 0) {
            // If the form name appears in the $_POST array we have a winner!
            if (isset($_POST[$name])) {
                $selected = array($_POST[$name]);
            }
        }

        if ($extra != '')
            $extra = ' ' . $extra;

        $multiple = (count($selected) > 1 && strpos($extra, 'multiple') === FALSE) ? ' multiple="multiple"' : '';

        $form = '<select name="' . $name . '"' . $extra . $multiple . ">\n";

        foreach ($options as $key => $val) {
            $key = (string) $key;

            if (is_array($val) && !empty($val)) {
                $form .= '<optgroup label="' . $key . '">' . "\n";

                foreach ($val as $optgroup_key => $optgroup_val) {
                    $sel = (in_array($optgroup_key, $selected)) ? ' selected="selected"' : '';

                    $form .= '<option value="' . $optgroup_key . '"' . $sel . '>' . (string) $optgroup_val . "</option>\n";
                }

                $form .= '</optgroup>' . "\n";
            } else {
                $sel = (in_array($key, $selected)) ? ' selected="selected"' : '';

                $form .= '<option value="' . $key . '"' . $sel . '>' . (string) $val . "</option>\n";
            }
        }

        $form .= '</select>';

        return $form;
    }

    function form_multiselect($name = '', $options = array(), $selected = array(), $extra = '') {
        if (!strpos($extra, 'multiple')) {
            $extra .= ' multiple="multiple"';
        }

        return $this->form_dropdown($name, $options, $selected, $extra);
    }

    function form_textarea($data = '', $value = '', $extra = '') {
        $defaults = array('name' => ((!is_array($data)) ? $data : ''), 'cols' => '40', 'rows' => '10');

        if (!is_array($data) OR !isset($data['value'])) {
            $val = $value;
        } else {
            $val = $data['value'];
            unset($data['value']); // textareas don't use the value attribute
        }

        $name = (is_array($data)) ? $data['name'] : $data;
        return "<textarea " . $this->_parse_form_attributes($data, $defaults) . $extra . ">" . $this->form_prep($val, $name) . "</textarea>";
    }

    function form_upload($data = '', $value = '', $extra = '') {
        if (!is_array($data)) {
            $data = array('name' => $data);
        }

        $data['type'] = 'file';
        return $this->form_input($data, $value, $extra);
    }

    function form_password($data = '', $value = '', $extra = '') {
        if (!is_array($data)) {
            $data = array('name' => $data);
        }

        $data['type'] = 'password';
        return $this->form_input($data, $value, $extra);
    }

    public function form_input($data = '', $value = '', $extra = '') {
        $defaults = array('type' => 'text', 'name' => ((!is_array($data)) ? $data : ''), 'value' => $value);

        return "<input " . $this->_parse_form_attributes($data, $defaults) . $extra . " />";
    }

    function form_hidden($name, $value = '', $recursing = FALSE) {
        static $form;

        if ($recursing === FALSE) {
            $form = "\n";
        }

        if (is_array($name)) {
            foreach ($name as $key => $val) {
                $this->form_hidden($key, $val, TRUE);
            }
            return $form;
        }

        if (!is_array($value)) {
            $form .= '<input type="hidden" name="' . $name . '" value="' . $this->form_prep($value, $name) . '" />' . "\n";
        } else {
            foreach ($value as $k => $v) {
                $k = (is_int($k)) ? '' : $k;
                $this->form_hidden($name . '[' . $k . ']', $v, TRUE);
            }
        }

        return $form;
    }

    function form_open_multipart($action = '', $attributes = array(), $hidden = array()) {
        if (is_string($attributes)) {
            $attributes .= ' enctype="multipart/form-data"';
        } else {
            $attributes['enctype'] = 'multipart/form-data';
        }

        return form_open($action, $attributes, $hidden);
    }

    function form_open($action = '', $attributes = '', $hidden = array()) {

        if ($attributes == '') {
            $attributes = 'method="post"';
        }

        // If an action is not a full URL then turn it into one
        if ($action && strpos($action, '://') === FALSE) {
            $action = $this->CI->config->site_url($action);
        }

        // If no action is provided then set to the current url
        $action OR $action = $this->CI->config->site_url($this->CI->uri->uri_string());

        $form = '<form action="' . $action . '"';

        $form .= $this->_attributes_to_string($attributes, TRUE);

        $form .= '>';

        // Add CSRF field if enabled, but leave it out for GET requests and requests to external websites    
        if ($this->CI->config->item('csrf_protection') === TRUE AND !(strpos($action, $this->CI->config->base_url()) === FALSE OR strpos($form, 'method="get"'))) {
            $hidden[$this->CI->security->get_csrf_token_name()] = $this->CI->security->get_csrf_hash();
        }

        if (is_array($hidden) AND count($hidden) > 0) {
            $form .= sprintf("<div style=\"display:none\">%s</div>", $this->form_hidden($hidden));
        }

        return $form;
    }

    public function getName() {
        return "app";
    }

}
?>

