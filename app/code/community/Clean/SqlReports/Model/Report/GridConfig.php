<?php
/**
 * Report Grid Config Model
 * @author Rolando Granadino <beeplogic@magenation.com>
 */
class Clean_SqlReports_Model_Report_GridConfig extends Varien_Object
{
    /**
     * get list of filterable columns
     * @return array
     */
    public function getFilterable()
    {
        $filterable = $this->getData('filterable');
        if (is_array($filterable)) {
            return $filterable;
        }
        return array();
    }

    /**
     * get list of columns to render
     */
    public function getRenderer()
    {
        $render = $this->getData('render');
        if (is_array($render)) {
            return $render;
        }
        return array();
    }

    /**
     * get list of columns for callback functions
     */
    public function getCallback()
    {
        $callback = $this->getData('callback');
        if (is_array($callback)) {
            return $callback;
        }
        return array();
    }
}