<?php

use App\CmsPage;
use Illuminate\Database\Seeder;

class CmsPagesTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = CmsPage::where('slug', 'how-it-works?')->count();
        if ($count == 0) {
            CmsPage::create([
                'name' => 'How it Works?',
                'short_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse.',
                'description' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse.</p>',
                'slug' => 'how-it-works?',
                'meta_title' => '',
                'meta_keyword' => '',
                'meta_content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse.',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }
        $count = CmsPage::where('slug', 'studio')->count();
        if ($count == 0) {
            CmsPage::create([
                'name' => 'Studio',
                'short_description' => 'About Case You Want Experienc Best Lawyers On Your Side',
                'description' => '<p class="font-eighteen law-content-pd">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan.</p>',
                'slug' => 'studio',
                'meta_title' => '',
                'meta_keyword' => '',
                'meta_content' => '',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }
        $count = CmsPage::where('slug', 'about-us')->count();
        if ($count == 0) {
            CmsPage::create([
                'name' => 'About Us',
                'short_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse.',
                'description' => '<p class="font-eighteen law-content-pd">http://www.unlockedassistant.com/ is a division of The Law Firm of Higbee &amp; Associates, a national law firm. Because of our attention to customer service and the quality of our services we have an "A+" rating with the Better Business Bureau. ShopperApproved.com has awarded http://www.unlockedassistant.com/ 4.8/5 stars with 796 positive reviews and counting. We have recently received a Client&rsquo;s Choice Award from Avvo due to our superb feedback. All of our attorneys are licensed by the state, graduated from top law schools, and have great reputations.</p>
				<p class="font-eighteen mb-0">Our law firm is about people. It is about knowing that there are few things more rewarding than helping people get the most out of their life. The members of this law firm are blessed to be able to make a difference for scores of people each month.</p>
				<p class="font-eighteen mb-0">To put our service within the financial reach of the most people possible, we had to do things differently. We started by hiring people who shared our passion for giving people a fresh start. Then we empowered them with the technology, training, and tools necessary to deliver high quality service for unbeatable low prices. Just look at this web site... where else can you chat with a live attorney online for free? Emails and phone calls are returned promptly. That is just the start.</p>
				<p class="font-eighteen mb-0">We explain every step of your case and notify you by email each time we take a step. When we complete the research on the case, you will know. When we mail something to the court on your behalf, you will know. You are never left wondering, "what is my attorney doing?"</p>
				<p class="font-eighteen mb-0">If you think all of that is unheard of from a law firm, try this... on most cases, we charge you a flat-fee that is guaranteed to be the lowest price available and we offer a money back guarantee.</p>',
                'slug' => 'about-us',
                'meta_title' => 'About Us | Unlocked',
                'meta_keyword' => 'about',
                'meta_content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse.',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }
        $count = CmsPage::where('slug', 'venue')->count();
        if ($count == 0) {
            CmsPage::create([
                'name' => 'Venue',
                'short_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse.',
                'description' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse.</p>',
                'slug' => 'venue',
                'meta_title' => 'For Venue | Unlocked',
                'meta_keyword' => 'venue',
                'meta_content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse.',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }

        $count = CmsPage::where('slug', 'contact-us')->count();
        if ($count == 0) {
            CmsPage::create([
                'name' => 'Contact Us',
                'short_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse.',
                'description' => '<div class="contactadd" data-node-uid="336">
				<p><strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit</strong></p>
				<h3 data-node-uid="346">Get In Touch</h3>
				<p><em class="fa fa-phone">&nbsp;</em> +1-1234-567-890</p>
				<p><em class="fa fa-envelope">&nbsp;</em> info@unlocked.com</p>
				<p><em class="fa fa-globe">&nbsp;</em> www.unlocked.com</p>
				<p data-node-uid="360">&nbsp;</p>
				</div>',
                'slug' => 'contact-us',
                'meta_title' => 'About Our Firm - Attorneys & Locations | Unlocked',
                'meta_keyword' => 'contact',
                'meta_content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse.',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }
        $count = CmsPage::where('slug', 'refund-and-cancellation-policy')->count();
        if ($count == 0) {
            CmsPage::create([
                'name' => 'Refund and Cancellation Policy',
                'short_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse.',
                'description' => '<div id="subcontent">
				<h1 class="block">Higbee &amp; Associates Refund and Cancellation Policy Updated September 23rd, 2010</h1>
				<div id="popup_block">
				<p>We request information about you so that we can notify you if the law changes or is about to change. We never share or sell your information.</p>
				<h4 class="first_header">What information do we collect?</h4>
				<p>We collect information from you when you visit our website, take our eligibility test, place an order, or fill out any forms. This includes names, contact information, case information, in certain cases financial information and other data needed to provide our service in the best way possible for our clients.</p>
				<p>We are the sole owners of the information collected on this site. We only have access to and collect information that you voluntarily give us via email, forms on our site, or other direct communication from you. You may request to see what data we have about you, if any. You can always opt out of any future contacts from us at any time. If you wish to have us delete any data we have about you or express any concern you have about our use of your data please use our contact page.</p>
				<h4>How do we protect your information?</h4>
				<p>We diligently guard your information because we have a professional duty as attorneys to preserve the attorney/client privilege and responsibility under state laws (including California stringent Online Privacy Protection Act) and federal law. We implement a variety of security measures to maintain the safety of your personal information when you place an order or enter, submit, or access your personal information.</p>
				<p>Wherever we collect sensitive information (such as credit card data), that information is encrypted and transmitted to us in a secure way. You can verify this by looking for a closed lock icon at the bottom of your web browser, or looking for "https" at the beginning of the address of the web page. All supplied private information is transmitted via Secure Socket Layer (SSL) technology and then encrypted and delivered to us. After a transaction, your private information (credit cards, social security numbers, financials, etc.) is stored on our internal servers (in a locked down server room) and protected behind and industrial strength firewalls.</p>
				<p>Your personal information, whether public or private, will not be sold, exchanged, transferred, or given to any other company for any reason whatsoever, without your consent, other than for the express purpose of providing the service requested.</p>
				<h4>What do we use your information for?</h4>
				<p>Any of the information we collect from you may be used in any of the following ways:</p>
				<ul>
				<li>To personalize your experience</li>
				<li>To improve our website</li>
				<li>To improve customer service</li>
				<li>To process transactions</li>
				<li>To respond to any questions or communication request</li>
				</ul>
				<h4>Do we use cookies?</h4>
				<p>Yes, we use cookies to help us remember and process the items in your shopping cart, understand and save your preferences for future visits, and compile aggregate data about site traffic and site interaction so that we can offer better site experiences and tools in the future. While we may contract with third-party service providers to assist us in better understanding our site visitors, we never provide them with your personal information. These service providers are not permitted to use the information collected on our behalf except to help us conduct and improve our business.</p>
				<p>If you prefer, you can choose to have your computer warn you each time a cookie is being sent, or you can choose to turn off all cookies via your browser settings. Like most websites, if you turn your cookies off, some of our services may not function properly. However, you can still place orders over the telephone.</p>
				<h4>Do we disclose any personal information to outside parties?</h4>
				<p>Never. We do not sell, trade, or otherwise transfer to outside parties your personally identifiable information unless necessary to provide the service you hired us to perform. Google, as a third party vendor, collects certain non-identifying information about our website visitors including how they came to our site, which operating system and browser they are using, and which pages they visited. We use this information to make our website easier to use and navigate, as well as for internal marketing purposes. To learn more about how google keeps your information private please read Google privacy policy.</p>
				<h4>Third Party links</h4>
				<p>Occasionally, at our discretion, we may include or offer third party products or services on our website. These third party sites have separate and independent privacy policies. We therefore have no responsibility or liability for the content and activities of these linked sites. Nonetheless, we seek to protect the integrity of our site and welcome any feedback about these sites.</p>
				<h4>Your Consent</h4>
				<p>By using our site, you consent to our privacy policy.</p>
				<h4>Changes to our Privacy Policy</h4>
				<p>If we decide to change our privacy policy, we will post those changes on this page, and/or update the Privacy Policy modification date below.</p>
				<p>This policy was last modified on September 23rd, 2010</p>
				<h4>Contacting Us</h4>
				<p>If there are any questions regarding this privacy policy you may contact us using the information below or by visiting <a class="external" href="www.unlocked.com" target="_blank" rel="noopener">www.unlocked.com</a> and filling out the form.</p>
				<p>123 example road 123 District, Abc port exampl city<br />info@yourmail.com<br />(1234)-567-890</p>
				</div>
				</div>',
                'slug' => 'refund-and-cancellation-policy',
                'meta_title' => 'Refund Cancellation Policy | Unlocked',
                'meta_keyword' => 'refund-and-cancellation-policy',
                'meta_content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse.',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
