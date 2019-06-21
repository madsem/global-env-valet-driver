<?php

class GlobalEnvValetDriver extends ValetDriver
{
    /**
     * Loads .valet-env.php from current parent working directory, for globally shared ENV vars.
     *
     * Load server environment variables if available.
     * Processes any '*' entries first, and then adds site-specific entries
     *
     * @param  string  $sitePath
     * @param  string  $siteName
     * @return void
     */
    public function loadServerEnvironmentVariables($sitePath, $siteName)
    {

        $varFilePath = realpath(dirname($sitePath, 1) . '/.valet-env.php');
        if (! file_exists($varFilePath)) {
            return;
        }
        $variables = include $varFilePath;
        $variablesToSet = isset($variables['*']) ? $variables['*'] : [];
        if (isset($variables[$siteName])) {
            $variablesToSet = array_merge($variablesToSet, $variables[$siteName]);
        }
        foreach ($variablesToSet as $key => $value) {
            if (! is_string($key)) continue;
            $_SERVER[$key] = $value;
            $_ENV[$key] = $value;
            putenv($key . '=' . $value);
        }
    }

    /**
     * Determine if the driver serves the request.
     *
     * @param  string  $sitePath
     * @param  string  $siteName
     * @param  string  $uri
     * @return false
     */
    public function serves($sitePath, $siteName, $uri)
    {
        $this->loadServerEnvironmentVariables($sitePath, $siteName);

        return false;
    }

    /**
     * Determine if the incoming request is for a static file.
     *
     * @param  string  $sitePath
     * @param  string  $siteName
     * @param  string  $uri
     * @return string|false
     */
    public function isStaticFile($sitePath, $siteName, $uri)
    {
        if (file_exists($staticFilePath = $sitePath.'/public/'.$uri)) {
            return $staticFilePath;
        }

        return false;
    }

    /**
     * Get the fully resolved path to the application's front controller.
     *
     * @param  string  $sitePath
     * @param  string  $siteName
     * @param  string  $uri
     * @return string
     */
    public function frontControllerPath($sitePath, $siteName, $uri)
    {
        return $sitePath.'/public/index.php';
    }
}
