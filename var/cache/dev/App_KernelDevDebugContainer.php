<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerOmJ2Fps\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerOmJ2Fps/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerOmJ2Fps.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerOmJ2Fps\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \ContainerOmJ2Fps\App_KernelDevDebugContainer([
    'container.build_hash' => 'OmJ2Fps',
    'container.build_id' => '23d51341',
    'container.build_time' => 1575039565,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerOmJ2Fps');
