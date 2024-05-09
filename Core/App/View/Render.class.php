<?php

namespace View;

abstract class Render {

    public function renderView($view, $layout, $metaParams, $bodyParams = [], $responseParams = [], $js = []) {
        $layoutContent = $this->layoutContent($layout);
        $viewContent = $this->viewContent($view, $bodyParams, $responseParams);
        // $viewCookiebar = $this->viewCookiebar();
        $viewJs = $this->viewJs($js);
        switch ($layout) {
            case 'admin-main':
            case 'user-main':
                $viewUMeta = $this->viewUMeta($metaParams);
                // $viewModal = $this->viewModal();
                $viewUNav = $this->viewUNav();
                $viewFooter = $this->viewFooter();
                $templates = [$viewUMeta, $viewUNav, $viewContent, $viewFooter, $viewJs];
                $markup = ['{{meta}}','{{nav}}','{{content}}','{{footer}}','{{js}}'];
                break;
            case 'main':
                $viewMeta = $this->viewMeta($metaParams);
                // $viewModal = $this->viewModal();
                $viewNav = $this->viewNav();
                $viewFooter = $this->viewFooter();
                $templates = [$viewMeta, $viewNav, $viewContent, $viewFooter, $viewJs];
                $markup = ['{{meta}}','{{nav}}','{{content}}','{{footer}}','{{js}}'];
                break;
            case 'simple':
                $viewMeta = $this->viewMeta($metaParams);
                $templates = [$viewMeta, $viewContent, $viewJs];
                $markup = ['{{meta}}','{{content}}','{{js}}'];
                break;
        }
        return str_replace($markup, $templates, $layoutContent);
    }

    public function layoutContent($layout) {
        ob_start();
        include_once COREAPP . "View/Layouts/$layout.tpl.php";
        return ob_get_clean();
    }

    public function viewMeta($metaParams) {
        ob_start();
        include_once COREAPP . 'View/Layouts/inc/meta.tpl.php';
        return ob_get_clean();
    }
    
    public function viewUMeta($metaParams) {
        ob_start();
        include_once COREAPP . 'View/Layouts/inc/umeta.tpl.php';
        return ob_get_clean();
    }

    public function viewHeader() {
        ob_start();
        include_once COREAPP . 'View/Layouts/inc/header.tpl.php';
        return ob_get_clean();
    }

    public function viewNav() {
        ob_start();
        include_once COREAPP . 'View/Layouts/inc/nav.tpl.php';
        return ob_get_clean();
    }

    public function viewUNav() {
        ob_start();
        include_once COREAPP . 'View/Layouts/inc/anav.tpl.php';
        return ob_get_clean();
    }

    public function viewContent($view, $bodyParams, $responseParams) {
        ob_start();
        include_once COREAPP . "View/Content/$view.tpl.php";
        return ob_get_clean();
    }

    public function viewFooter() {
        ob_start();
        include_once COREAPP . 'View/Layouts/inc/footer.tpl.php';
        return ob_get_clean();
    }

    public function viewJs($js) {
        ob_start();
        include_once COREAPP . 'View/Layouts/inc/js.tpl.php';
        return ob_get_clean();
    }
}
