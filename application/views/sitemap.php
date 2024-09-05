<?php
  header('Content-type: application/xml; charset="ISO-8859-1"',true);  
  $datetime1 = new DateTime(date('Y-m-d H:i:s'));
?>
 
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url>
    <loc><?php echo base_url(); ?></loc>
    <lastmod><?php echo $datetime1->format(DATE_ATOM); ?></lastmod>
    <changefreq>daily</changefreq>
    <priority>0.1</priority>
  </url>
  <url>
    <loc><?php echo base_url(); ?>login-page</loc>
    <lastmod><?php echo $datetime1->format(DATE_ATOM); ?></lastmod>
    <changefreq>daily</changefreq>
    <priority>0.80</priority>
  </url>
  <url>
    <loc><?php echo base_url(); ?>sitemap.xml</loc>
    <lastmod><?php echo $datetime1->format(DATE_ATOM); ?></lastmod>
    <changefreq>daily</changefreq>
    <priority>0.80</priority>
  </url>
</urlset>