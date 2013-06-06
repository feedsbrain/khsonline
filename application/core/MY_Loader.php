<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @description	Allows you to use templates in CodeIgniter
 * 				Written and tested in CI 2.0.3
 * 				Original release 26-dec-2008
 * 				Usage (in your controller):
 * 					$this->load->template('template_path/template_filename_without_php');
 * 						(just like you load a view)
 * 					then just do: 
 * 					$this->load->view('view_path/view_filename_without_php');
 * 					for your own conveniece I recommend loading the template in the constructor
 * 					of your controller
 * 
 * 				Limitations:
 * 				i) You can't load multiple views from a method in your controller unless
 * 					your template displays only the top part of a template.
 * 					In plain english, if you load 2 views in a single method, the second view 
 * 					will be loaded after the </body></html> part of your template.
 * 					To overcome this, load any extra views from within the first view so that
 * 					there is only one view loaded from the controller's method
 * 
 * @author		Vangelis Bibakis, bibakisv@gmail.com
 * @license		You are free to use the code in your projects, commercial or not.
 * 				You are free to modify and redistribute the code as long as you 
 * 					don't remove the author information and these lines about the license.
 * 				You are free to charge for installing or supporting this library.
 * 				You are not allowed to redistribute the code under a different license or 
 * 	 				sell the code.
 * 				You are not allowed to remove the orginal author info even if you make 
 * 					changes or additions to the code.
 * @version		0.2
 * @date		29/9/2011
 * */
class MY_Loader extends CI_Loader {

    var $template = '';
    var $data = array();
    var $return = FALSE;
    var $template_loaded;
    var $css_files = array();
    var $js_files = array();

    /**
     * Allows the loading of templates. Normaly you want pages with the same layout across your site.
     * If you decide to load a template, then any of the views you load afterwards will be placed inside
     * the template's code in the position with the $content variable
     * 
     * @param $template		The filename of the template to use, in the style of loading a view
     * @param $data			Any data you wish to pass to the template, in a data array just like the views
     * @param $return		If you want to just get the template contents set to true
     */
    function theme($template = '', $data = array(), $return = FALSE) {
        if ($template == '') {
            return FALSE;
        }

        $this->template = $template;
        $this->data = $this->_ci_object_to_array($data);
        $this->return = $return;

        if (count($this->css_files) > 0) {
            $includes = '';
            foreach ($files as $file_array) {
                foreach ($file_array as $type => $file) {
                    if (!((substr($file, 0, 7) == 'http://') OR (substr($file, 0, 7) == 'https:/'))) {
                        $file = base_url() . $file;
                    }

                    if ($type == 'css') {
                        $includes .= '<link rel="stylesheet" type="text/css" href="' . $file . '" media="screen" />';
                    } elseif ($type == 'js') {
                        $includes .= '<script type="text/javascript" src="' . $file . '"></script>';
                    }
                }
            }
            $this->data['includes'] = $includes;
        }
    }

    /**
     * Checks if a template has already been loaded and then either loads the view directly or puts it inside 
     * the template and loads it with the view.
     * 
     * @see /system/libraries/CI_Loader#view($view, $vars, $return)
     */
    function view($view, $vars = array(), $return = FALSE) {
        // this part loads a view
        if (($this->template == '') || ($this->template_loaded == TRUE)) {
            $this->template_loaded = TRUE;
            return $this->_ci_load(array(
                        '_ci_view' => $view,
                        '_ci_vars' => $this->_ci_object_to_array($vars),
                        '_ci_return' => $return)
            );
        }
        // this part loads the template
        else {
            $this->template_loaded = TRUE;
            $data = $this->_ci_object_to_array($vars);


            // adds the template $data 
            if (count($this->data) > 0) {
                foreach ($this->data as $key => $value) {
                    $data[$key] = $value;
                }
            }

            $data['content'] = $this->_ci_load(array(
                '_ci_view' => $this->template . '/' . $view . '.php',
                '_ci_vars' => $this->_ci_object_to_array($vars),
                '_ci_return' => TRUE)
            );


            $data['includes'] = '';
            $this->css_files = array_unique($this->css_files);
            foreach ($this->css_files as $css_file) {
                $data['includes'] .= '<link rel="stylesheet" type="text/css" href="' . $css_file . '" media="screen" /> ';
            }

            $this->js_files = array_unique($this->js_files);
            foreach ($this->js_files as $js_file) {
                $data['includes'] .= '<script type="text/javascript" src="' . $js_file . '"></script>';
            }

            return $this->_ci_load(array(
                        '_ci_view' => '../../assets/themes/' . $this->template . '/theme.php',
                        '_ci_vars' => $data,
                        '_ci_return' => $return)
            );
        }
    }

    function js($filename) {
        if ((substr($filename, 0, 7) != 'http://') && (substr($filename, 0, 8) != 'https://')) {
            $filename = base_url() . $filename . cjsuf();
        }

        $this->js_files[] = $filename;
    }

    function css($filename) {
        if ((substr($filename, 0, 7) != 'http://') && (substr($filename, 0, 8) != 'https://')) {
            $filename = base_url() . $filename . cjsuf();
        }
        $this->css_files[] = $filename;
    }

}

/* End of file MY_Loader.php */
/* Location: ./app/core/MY_Loader.php */