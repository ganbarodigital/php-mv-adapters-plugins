# CHANGELOG

## develop branch

### New

* Added initial exceptions
  - `AdaptersAndPluginsException` base exception
  - `NoSuchPluginClass` exception
  - `NoSuchPluginClassMethod` exception
  - `NotAPluginClass` exception
  - `NotAPluginProvider` exception
* Added initial checks
  - `IsPluginProvider` check
  - `IsPluginClass` check
* Added initial robustness requirements
  - `RequirePluginProvider` requirement
  - `RequirePluginClass` requirement
  - `RequirePluginClassMethod` requirement
* Added useful utilities
  - `BuildTargetClassName` helper
* Added ability to call plugins
  - `CallPlugin` operation
* Added basic types
  - `PluginProvider`
  - `PluginClass`