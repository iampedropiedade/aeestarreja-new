<?php

namespace Concrete\Package\Picture\Adapter;

interface SourceInterface {
    /**
     * FDQN of an ImageEditorInterface
     *
     * @return string
     */
    public function getImageEditorClass(): string;
}
