<?php
/**
 * Plugin Name: MainWP Sites SEO Report
 * Plugin URI: http://semlab.be
 * Description: This <strong>plugin show SEO statistics for all network sites</strong> from MainWP dashboard. <br/>Just install on MainWP dashboard/admin, and use <strong>PLUGINS menu</strong> to have detailed table with SEO factors. <br/>Support for this is given on official MainWP forum.
 * Version: 0.1.1
 * Author: SEMLAB
 * Author URI: http://semlab.be
 * License: GPL 2.0
 */
 
add_action( 'admin_menu', 'MWPSSEO_menu' );
function MWPSSEO_menu() {
add_submenu_page("plugins.php", "MainWP Sites SEO Report", "MainWP SEO", 10, __FILE__, 'MWPSSEO_options');
}
function MWPSSEO_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	echo '<div class="wrap">';
	echo '<p>This plugin shows detailed SEO statistics for MainWP childs.</p>';

 global $wpdb;
 $site_list = $wpdb->get_results("SELECT name,url,pagerank,indexed,alexia,pagerank_old,indexed_old,alexia_old FROM `wp_mainwp_wp`");

				echo '				
				<table id="mainwp-table" class="wp-list-table widefat" cellspacing="0">
				 <thead>
				  <tr>
				    <th scope="col" id="cb" class="manage-column sorted"><span>Site</span></th>
					<th scope="col" id="cb" class="manage-column sorted"><span>PR</span></th>
					<th scope="col" id="cb" class="manage-column sorted"><span>PR old</span></th>
					<th scope="col" id="cb" class="manage-column sorted"><span>Indexed</span></th>
					<th scope="col" id="cb" class="manage-column sorted"><span>Indexed old</span></th>
					<th scope="col" id="cb" class="manage-column sorted"><span>Alexia</span></th>					
					<th scope="col" id="cb" class="manage-column sorted"><span>Alexia old</span></th>
				  </tr>
				</thead>
				';
				
echo '<tbody id="the-sites-list" class="list:sites">';
 
 foreach ($site_list as $site) {
 $site_name = $site->name;
 $site_url = $site->url;
 $site_pagerank = $site->pagerank;
 $site_pagerank_old = $site->pagerank_old;
 $site_indexed = $site->indexed;
 $site_indexed_old = $site->indexed_old;
 $site_alexia = $site->alexia;
 $site_alexia_old = $site->alexia_old;

 $prcolor = ( $site_pagerank <  $site_pagerank_old) ? "red" : "green";
 $indexedcolor = ($site_indexed <  $site_indexed_old) ? "red" : "green";
 $alexiacolor = ($site_alexia < $site_alexia_old) ? "red" : "green";

echo'
<tr id="site-1" siteid="1">
<td scope="row" class=""><a href="'.$site_url.'" target=_blank />'.$site_name.'</a></td>
<td style="color:'.$prcolor.'">'.$site_pagerank.'</td>
<td style="color:grey">'.$site_pagerank_old.'</td>
<td style="color:'.$indexedcolor.'">'.$site_indexed.'</td>
<td style="color:grey">'.$site_indexed_old.'</td>
<td style="color:'.$alexiacolor.'">'.$site_alexia.'</td>
<td style="color:grey">'.$site_alexia_old.'</td>
</tr>';
} 

echo '</tbody></div>';
echo '<div style="clear:both"></div>';
}
?>