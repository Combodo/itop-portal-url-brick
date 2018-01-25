Below is an example of UrlBrick instance.
Current XML alteration from this brick (see datamodel.itop-portal-url-brick.xml) only adds the brick's css. You must invoke an instance of the brick yourself in order to have it on the portal.

WARNING: The current XML alteration and the following example are hard-coded on portal instance of id "itop-portal", you must change it if necessary.

Brick configuration EXAMPLE:
	<?xml version="1.0" encoding="UTF-8"?>
	<itop_design xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" version="1.3">
		<module_designs>
			<module_design id="itop-portal" xsi:type="portal">
				<bricks>
					<!-- Exemple for a UrlBrick -->
					<brick id="url-to-combodo-website" xsi:type="Combodo\iTop\Portal\Brick\UrlBrick" _delta="define">
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
						<!-- URL of the webpage to display. Note: Omitting the "http:" will make the iframe automatically use the same protocol "http|https" as the parent web page. This is mostly necessary when the server is forced to https. -->
						<url>//wiki.openitop.org</url>
						<!-- FQN of a static method (without parenthesis) that returns an array of extra parameters (param => value) to add to the URL. -->
						<!-- Returned parameters will be url-encoded automatically. -->
						<!-- Note: Extra code can be done there like setting cookies or so. -->
						<!--<url_parameters_callback><![CDATA[\Ticket::Foo]]></url_parameters_callback>-->
						<!-- Fullscreen true|false. Defines if the webpage is displayed with its title and subtitle or fills all the page. Default is false. -->
						<!--<fullscreen>false</fullscreen>-->
					</brick>
				</bricks>
			</module_design>
		</module_designs>
	</itop_design>

Callback method EXAMPLE:
	class Ticket
	{
		public static function FooMethod()
		{
			// Should return an array of parameters to add o the url (can be empty or null though).
			$aParams = array();

			// Exemple: Manually creating parameters
			//$aParams['param1'] = 'foo';
			//$aParams['param2'] = 'bar';

			// Exemple: Doing something that has nothing to do with the actual URL (like setting a cookie)
			//setcookie('MyCookieName', 'MyCookieValue');
			
			$aParams = array(
				'search' => 'foo',
				'orderby' => 'date',
			);

			return $aParams;
		}
	}