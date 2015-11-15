<?php
namespace UserAgentParserTest\Provider;

/**
 * @covers UserAgentParser\Provider\AbstractProvider
 */
class AbstractProviderTest extends AbstractProviderTestCase
{
    public function testVersionNull()
    {
        $provider = $this->getMockForAbstractClass('UserAgentParser\Provider\AbstractProvider');

        // no package name
        $this->assertNull($provider->getVersion());

        // no composer.lock found
        $cwdir = getcwd();
        chdir('tests');

        $provider = $this->getMockForAbstractClass('UserAgentParser\Provider\AbstractProvider');
        $provider->expects($this->any())
            ->method('getComposerPackageName')
            ->will($this->returnValue('something/other'));

        $this->assertNull($provider->getVersion());
        chdir($cwdir);

        // no package match
        $provider = $this->getMockForAbstractClass('UserAgentParser\Provider\AbstractProvider');
        $provider->expects($this->any())
            ->method('getComposerPackageName')
            ->will($this->returnValue('something/other'));

        $this->assertNull($provider->getVersion());
    }

    public function testVersion()
    {
        $provider = $this->getMockForAbstractClass('UserAgentParser\Provider\AbstractProvider');
        $provider->expects($this->any())
            ->method('getComposerPackageName')
            ->will($this->returnValue('browscap/browscap-php'));

        // match
        $this->assertInternalType('string', $provider->getVersion());

        // cached
        $this->assertInternalType('string', $provider->getVersion());
    }
}