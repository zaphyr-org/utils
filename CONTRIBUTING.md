# How to Contribute

Contributions are welcome and will be fully credited.
I accept contributions via Pull Requests on [Github](https://github.com/zaphyr-org/utils).

## Pull Requests

- **[PSR-12 Coding Standard](https://www.php-fig.org/psr/psr-12/)** - The easiest way to apply the conventions is to install [PHP Code Sniffer](http://pear.php.net/package/PHP_CodeSniffer).

- **Add tests!** - Your patch won't be accepted if it doesn't have tests.

- **Document any change in behaviour** - Make sure the `README.md` and any other relevant
  documentation are kept up-to-date.

- **Consider the release cycle** - I try to follow [SemVer v2.0.0](http://semver.org/).
  Randomly breaking public APIs is not an option.

- **Create feature branches** - Don't ask me to pull from your master branch.

- **One pull request per feature** - If you want to do more than one thing,
  send multiple pull requests.

- **Send coherent history** - Make sure each individual commit in your pull request is meaningful.
  If you had to make multiple intermediate commits while developing, please
  [squash them](http://www.git-scm.com/book/en/v2/Git-Tools-Rewriting-History#Changing-Multiple-Commit-Messages)
  before submitting.

## Commit message rules

There are some rules for what a commit message should look like. Here is an example of a final commit message:

```
New: A super new feature

Most importantly, describe what is changed with the commit and not what is has not been working (that is part of the
bug report already).

* Bullet points are okay, too
* An asterisk is used for the bullet, it can be preceded by a single
  space.
```

#### Summary line (first line)

A summary line starts with a keyword (e.g. `New`) and a brief summary of what the change does. Make sure to describe
how the behavior is now, not how it used to be - in the end, telling someone what was broken doesn't help anyone,
you want to tell what is working now.

Prefix the line with a keyword. Possible keywords are:

| Keyword       | Description
|---------------|------------
`New`           | A new feature or element. Also small additions
`Changed`       | A change (which is not a bugfix) to an existing component
`Deprecated`    | A new deprecation of a feature or function
`Removed`       | Removal of a feature or function
`Fixed`         | A fix for a bug
`Security`      | A security fix

#### Description (Message body)

Here you can go into detail about the how and why of the change. It should be brief, but yet descriptive
so people reviewing your change get an idea what they need to look out for.

## Running Tests

Please use the `composer test` command to run tests. This command will run the
[phpunit](https://phpunit.de/) tests, the
[phpstan](https://phpstan.org/) analyse and also checks for
[PSR12 Coding Standard](https://www.php-fig.org/psr/psr-12/).

```console
$ composer test
```
