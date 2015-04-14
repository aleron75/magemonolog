magemonolog
===========

Facts
-----
Version: 0.2.2
Developed (and tested) on Magento CE v 1.8.1.0

Introduction
------------

A Magento extension which provides a custom writer model to transparently use 
Monolog as logging library.

The following Monolog's Handlers are supported at the moment:

* `StreamHandler` - writes to file
* `NativeMailHandler` - sends each log entry via email
* `NewRelicHandler` - logs in NewRelic app

Installation
------------

You can install this extension in several ways:

**Download**

Download the full package, copy the content of the `app` directory
in your Magento base directory; pay attention not to overwrite
the `app` folder, only merge its contents into existing directory;

**Modman**

Install modman Module Manager: https://github.com/colinmollenhour/modman

After having installed modman on your system, you can clone this module on your
Magento base directory by typing the following command:

    $ modman init
    $ modman clone git@github.com:aleron75/magemonolog.git

**Composer**

Install composer: http://getcomposer.org/download/

Install Magento Composer: https://github.com/magento-hackathon/magento-composer-installer

Type the following command:

    $ php composer.phar require aleron75/magemonolog:dev-master

or

    $ composer require aleron75/magemonolog:dev-master

**Common tasks**

After installation:

* if you have cache enabled, disable or refresh it;
* if you have compilation enabled, disable it or recompile the code base.

Usage example
-------------
Once installed, the module automatically replaces the default Magento Log Writer
with Monolog's StreamHandler.

This is obtained through the following config node in `config.xml`:

    <config>
        <global>
            <log>
                <core>
                    <writer_model>Aleron75_Magemonolog_Model_Logwriter</writer_model>
                </core>
            </log>
        </global>
    </config>

which instructs Magento to use a custom log writer class when logging via the
`Mage::log()` native static function.

The configured `Aleron75_Magemonolog_Model_Logwriter` class is a wrapper for
Monolog and allows to use Monolog's Handlers.

Monolog's Handlers are configured in the `config.xml` through the following
config node:

    <config>
        <default>
            <magemonolog>
                <handlers>
                    <StreamHandler>
                        <active>1</active>
                        <params>
                            <stream>magemonolog.log</stream>
                            <level>DEBUG</level>
                            <bubble>true</bubble>
                            <filePermission>null</filePermission>
                            <useLocking>false</useLocking>
                        </params>
                    </StreamHandler>
                    <NativeMailHandler>
                        <active>0</active>
                        <params>
                            <to>dummy@example.com</to>
                            <subject>Log</subject>
                            <from>dummy@example.com</from>
                            <level>ERROR</level>
                            <bubble>true</bubble>
                            <maxColumnWidth>70</maxColumnWidth>
                        </params>
                    </NativeMailHandler>
                    <NewRelicHandler>
                        <active>0</active>
                        <params>
                            <level>ERROR</level>
                            <bubble>true</bubble>
                            <appname>***your app name here***</appname>
                        </params>
                    </NewRelicHandler>
                </handlers>
            </magemonolog>
        </default>
    </config>

It is assumed you know Monolog's Handlers to understand the meaning of `params`
node.

Multiple Log Handlers can be activated at the same time with different log
filter level; this way, for example, it is possible to log any message into a
file and only serious errors via e-mail.

You can also use Monolog's Formatters like shown below:

    <config>
        <default>
            <magemonolog>
                <handlers>
                    <StreamHandler>
                        <active>1</active>
                        <params>
                            <stream>magemonolog.log</stream>
                            <level>DEBUG</level>
                            <bubble>true</bubble>
                            <filePermission>null</filePermission>
                            <useLocking>false</useLocking>
                        </params>
                    <formatter>
                        <class>LogstashFormatter</class>
                        <args>
                            <application_name><![CDATA[MyAppName]]></application_name>
                            <system_name><![CDATA[]]></system_name>
                            <extra_prefix><![CDATA[]]></extra_prefix>
                            <context_prefix><![CDATA[]]></context_prefix>
                            <version><![CDATA[]]></version>
                        </args>
                    </formatter>
                    </StreamHandler>
                </handlers>
            </magemonolog>
        </default>
    </config>

The `<args>` tag should contain proper Formatter's contructor arguments. Arguments' tag name is not important, values
are passed to Formatter's constructor in the exact order the constructor requires them. You should consult Formatter's
constructor signature to know which are its arguments, their meaning and their order.

Closing words
-------------
Any feedback is appreciated.

This extension is published under the [Open Software License (OSL 3.0)](http://opensource.org/licenses/OSL-3.0).

Any contribution or feedback is extremely appreciated.
