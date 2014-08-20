<?php

/**
 *
 */
class PhloorBackgroundImage extends PhloorElggThumbnails {

    /**
     * Set subtype to news.
     */
    protected function initializeAttributes() {
        parent::initializeAttributes();

        $this->attributes['subtype']   = "phloor_background_image";
        $this->attributes['access_id'] = ACCESS_PUBLIC;
    }

}