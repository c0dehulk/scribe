# Scribe
This library contains tooling for generating documentation for Packages.


## Usage
To run the documentation generator, use the `generate` command:

```
vendor/bin/scribe generate --config=path/to/config.php
```

### Versioning
To tag the documentation with a specific build, or version, use the `build` option:
```
vendor/bin/scribe generate --config=path/to/config.php --build=1.2.3
```

## License
See [LICENSE.md](LICENSE.md).
