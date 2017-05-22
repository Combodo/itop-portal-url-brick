Below is an example of UrlBrick instance:

<?xml version="1.0" encoding="UTF-8"?>
<itop_design xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" version="1.3">
	<module_designs>
		<module_design id="itop-portal" xsi:type="portal">
			<bricks>
				<!-- Exemple for a UrlBrick -->
				<brick id="url-to-combod-website" xsi:type="Combodo\iTop\Portal\Brick\UrlBrick" _delta="define">
                    <rank>
                        <default>90</default>
                    </rank>
                    <width>6</width>
                    <title>
                        <default>www.combodo.com</default>
                    </title>
                    <description>
                        <![CDATA[ <p>Combodo website</p> ]]>
                    </description>
                    <decoration_class>
                        <default>fa fa-globe fa-2x</default>
                    </decoration_class>
                    <!-- Text or dictionary entry to be displayed uneder the brick title -->
                    <!--<subtitle/>-->
                    <!-- URL of the webpage to display. Note: Omitting the "http:" will make the iframe automatically use the same protocol "http|https" as the parent web page. This is mostly necessary when one the server is forced to https. -->
                    <url>//wiki.openitop.org</url>
                    <!-- Fullscreen true|false. Defines if the webpage is displayed with its title and subtitle or fills all the page. Default is false. -->
                    <!--<fullscreen>false</fullscreen>-->
                </brick>
			</bricks>
		</module_design>
	</module_designs>
</itop_design>
