# Simple Slow Test Reporter
> Reports slow tests in your PHPUnit testsuite

[![Example output of slow test reporter, highlighting some slow testcases](example.png)](example.png)

## Requirements
Requires PHPUnit 9, 10 or 11. Use v1 for PHPUnit 9, and v2 for PHPUnit 10 and later. This extension does not support PHPUnit 8 and earlier versions.

| PHPUnit version | SSTR version |
| --- | --- |
| 9.x | 1.x |
| 10.x | 2.x |
| 11.x | 2.x |

## Installation
Add the reporter as a dev dependency:
```bash
composer require --dev jakobbuis/simple-slow-test-reporter
```

### PHPUnit 10-11
Add the extension to your `phpunit.xml` file as a root-node:
```xml
<phpunit>
    [...]
    <extensions>
        <bootstrap class="SSTR\SlowTestReporter" />
    </extensions>
</phpunit>
```

Optionally, you can configure the threshold for a slow test. The default is 500 milliseconds.
```xml
<phpunit>
    [...]
    <extensions>
        <bootstrap class="SSTR\SlowTestReporter">
            <parameter name="threshold" value="1000"/>
        </bootstrap>
    </extensions>
</phpunit>
```

### PHPUnit 9
Add the extension to your `phpunit.xml` file as a root-node:
```xml
<phpunit>
    [...]
    <extensions>
        <extension class="SSTR\SlowTestReporter" />
    </extensions>
</phpunit>
```

Optionally, you can configure the threshold for a slow test. The default is 500 milliseconds.
```xml
<phpunit>
    [...]
    <extensions>
        <extension class="SSTR\SlowTestReporter">
            <arguments>
                <integer>1000</integer>
            </arguments>
        </extension>
    </extensions>
</phpunit>
```

## License
MIT
