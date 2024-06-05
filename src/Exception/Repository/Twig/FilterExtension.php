<?php

namespace ScoRugby\Core\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use ScoRugby\Core\Exception\InvalidArgumentException;

class FilterExtension extends AbstractExtension {

    const DEFAULT_VALUE = 'default';
    const FILTER_MODE = 'filter';
    const SORT_MODE = 'sort';

    private $tagExtension;

    public function __construct() {
        $this->tagExtension = new TagExtension();
    }

    public function getFunctions() {
        return [
            new TwigFunction('SelectFilter', [$this, 'Select'], ['is_safe' => ['html']])
        ];
    }

    /**
     *
     * @param string $type sort|path
     * @param array $options {value} => ['path' => "xxx", 'label'=> "xxx", 'attr'=>[]
     * @param array $attr
     * @return string
     */
    public function Select($mode, $options, $attr): string {
        $this->initializeControl('select', $mode, $attr);
        forEach ($options as $value => $option) {
            $optAttr['value'] = $value;
            $optAttr['data-path'] = $option['path'];
            if ($mode == self::SORT_MODE) {
                $optAttr['data-order'] = $option['order'];
                if ($option['path'] != self::DEFAULT_VALUE) {
                    $optAttr['data-type'] = "text";
                }
            }
            if (!array_key_exists('attr', $option)) {
                forEach ($optAttr as $key => $val) {
                    $optAttr[$key] = $val;
                }
            }
            $values[] = $this->tagExtension->content('option', $option['label'], $optAttr);
        }
        return $this->tagExtension->content('select', implode("\n", $values), $this->attributes($attr));
    }

    public function Button($mode, $label, $attr): string {
        $this->initializeControl('button', $mode, $attr);
        if (array_key_exists('icon', $attr)) {
            $attr = array_merge($attr, ['icon' => $attr['icon']]);
        }
        /** data-mode: Defines filter behaviour.radio*|checkbox */
        if (array_key_exists('mode', $attr)) {
            $mode = $attr['mode'];
        } else {
            $mode = 'radio';
        }
        $attr['data-mode'] = $mode;
        if (strtolower($attr['type']) == 'text') {
            $attr['data-text'] = $attr['value'];
        }

        return $this->tagExtension->content('button', $label, $this->attributes($attr));
    }

    public function Checkbox($type, $label, $attr): string {
        /** Checked|data-selected */
        if (array_key_exists('active', $attr) && $attr['active'] === true) {
            $attributes = [];
            if (array_key_exists('attr', $attr)) {
                $attributes = $filter['attr'];
            }
            $class = [];
//if( filter.attr.class', $attr) ){
//    $class = filter.attr.class|split(' ')
//}
            $class = array_merge($class, ['active']);
            $attributes = array_merge($attributes, ["class" => implode(' ', $class)]);
            $attr = array_merge($attr, ['attr' => $attributes]);
            if (in_array($type, ['radio', 'checkbox'])) {
                $attr['checked'] = true;
                $attr['data-selected'] = true;
            }
        }
        return $this->tagExtension->tag('input', $attr, 'true');
    }

    public function Radio($type, $label, $attr): string {
        /** name (only for radio) */
        $name[] = ucfirst($type);
        if (strtolower($attr[type]) == 'text') {
            $name[] = ucfirst($attr['path']);
        } else {
            $name[] = ucfirst($attr['group']);
            $name[] = "Options";
        }
        $attr['name'] = $this->sanitize($name);
        return $this->tagExtension->tag('input', $this->attributes($attr), 'true');
    }

    public function Text($type, $label, $attr): string {
        return $this->tagExtension->tag('input', $attr, 'true');
    }

    public function Dropdown($type, $label, $options, $attr): string {
        switch ($type) {
            case 'sort':
                $attr['data-jplist-control'] = "dropdown-sort";
                break;
            case 'path':
                $attr['data-jplist-control'] = "dropdown-filter";
                break;
            default:
                throw new InvalidArgumentException("Seulement les types 'sort', 'path' sont admis pour le control 'dropdown'");
        }
    }

    private function initializeId(array &$attr) {
        /** id */
        if (array_key_exists('id', $attr)) {
            $id = $attr['id'];
        } else {
            $id[] = ucfirst($type);
            if (array_key_exists('path', $attr)) {
                $id[] = ucfirst(str_replace('.', '', $attr['path']));
            }
            if (array_key_exists('value', $attr) && $attr['value']) {
                $id[] = ucfirst(filter['value']);
            } else {
                $id[] = 'Default';
            }
        }
        $attr['id'] = $this->sanitize($id);
    }

    private function initializeDefaultValues(array &$attr): array {
        /** filter.type */
        if (!array_key_exists('type', $attr)) {
            $attr['type'] = 'path';
        }
        /** default path, used in id and name. path is MANDATORY */
        if (!array_key_exists('path', $attr) && $attr['type'] == 'path') {
            $attr['path'] = '.default';
        }
        /** filter.value, value is used only for filter */
        if ($attr['type'] == 'text' && !array_key_exists('value', $attr)) {
            $attr['value'] = '';
        }
        /** default group, used in "name" */
        if (!array_key_exists('group', $attr)) {
            $attr['group'] = 'filter-group';
        }
        return $attr;
    }

    /* if (strtolower($attr['type']) == 'text') {
      if ($type == 'button') {
      $attr['data-text'] = $attr['value'];
      } else {
      $attr['value'] = $attr['value'];
      }
      } */

    /**
     * data-jplist-control : Defines radio buttons sort control.
     * 
     * @param type $widget
     * @param type $mode filter|sort
     * @param array $attr Attributes
     * @return void
     * @throws InvalidArgumentException
     */
    private function initializeControl($widget, $mode, array &$attr): void {
        /** data-jplist-control="sort-buttons" */
        /** data-jplist-control="radio-buttons-sort" */
        /** data-jplist-control="checkbox-sort" */
        /** data-jplist-control="select-sort" */
        if (array_key_exists('control', $attr)) {
            $attr['data-jplist-control'] = strtolower($attr['control']);
        } elseif ($type == 'button') {
            $attr['data-jplist-control'] = strtolower("buttons-" . $attr['type'] . "-filter");
        } else {
            $attr['data-jplist-control'] = strtolower($type . "-" . $attr['type'] . "-filter");
        }
        if (!in_array($mode, ['filter', 'sort'])) {
            throw new InvalidArgumentException("Seulement les types 'sort', 'filter' sont admis pour le control 'select'");
        }
        $attr['data-jplist-control'] = strtolower($widget . "-" . $mode);
    }

    /**
     * retourne les attibtus de l'élement HTML pour jplist
     * 
     * @param array $attr {"data-group": '', "data-path": '' }
     * @return string
     */
    private function attributes(&$attr): array {
        /**
         * default values
         */
        $this->initializeId($attr);
        $this->initializeDefaultValues($attr);
        $this->initializeName($attr);

        // data-action
        $attr['data-action'] = 'filtre';

        /**
         * data-datetime-format: This attribute is used when data-type="datetime". 
         *                       It defines the structure of the date using following wildcards: {year}, {month}, {day}, {hour}, {min}, {sec}.
         *                       Date structure, for example: data-datetime-format="{month} {day}, {year}"
         * data-filtre: 
         * data-group: Defines group of items that should be sorted.
         * data-jump: This data attribute can be used to scroll page to the specified location when user changes a checkbox value.
         *            data-jump="top" scrolls page to the top. Any CSS selector can be used instead of top keyword.
         * data-or
         * data-order: Specifies the sort order = asc|desc
         * data-path: CSS selector that defines the HTML element that should be sorted "default" keyword for the initial value or any CSS selector
         * data-type: Specifies the type of content that should be sorted = text|number|datetime
         */
        $data = ['datetime', 'filtre', 'group', 'jump', 'path', 'order', 'or' => 'or_group', 'type' => 'datatype'];
        forEach ($data as $key => $val) {
            if (array_key_exists($val, $attr)) {
                if (!is_string($key)) {
                    $key = $val;
                }
                $attr['data-' . $key] = strtolower($attr[$val]);
            }
        }

        /** data-id: This attribute is used for deep linking. */
        /* if (array_key_exists('id', $attr)) {
          $attr["data-id"] = $attr['id'];
          } */
        if (array_key_exists('attr', $attr)) {
            $attr = array_merge($attr, $attr['attr']);
        }
        return $attr;
    }

    /**
     * Initialize data-name
     * 
     * The data-name attribute is used to identify the same controls in different panels.
     * Different controls should have different data-name attributes.
     * By default, data-name attribute has default value.
     * 
     * @param array $attr
     * @return void
     */
    private function initializeName(array &$attr): void {
        if (array_key_exists('name', $attr)) {
            $name = $attr['name'];
        } else {
            $name = str_replace(".", "", $attr['path']);
        }
        $attr['data-name'] = $name;
    }

    private function sanitize($param): string {
        if (is_array($param)) {
            $param = implode("", $param);
        }
        return str_replace(['-', '.', '_', ' '], "", $param);
    }

}
