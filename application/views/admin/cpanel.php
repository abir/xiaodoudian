<!-- To do: Replace the shitty inline styles and update the message -->
<strong><?php echo sprintf(lang('cp_welcome'), $this->settings->item('site_name'));?></strong>
<div class='clear'></div>
<!-- Fancy site stats -->
<div class='dashboard_box' id='stats_box'>
	<h3>Site Info</h3>
	<ul class='dashboard_list' id='stats_list'>
		<li>
			<?php if($this->data->total_pages == 1)
			{
				echo '1 Page';
			}
			else
			{
				echo $this->data->total_pages . ' Pages';
			}
			?>
		</li>
		<li>
			<?php if($this->data->live_articles == 1)
			{
				echo '1 Article';
			}			
			else
			{
				echo $this->data->live_articles . ' Articles';
			}
			?>
		</li>
		<li>
			<?php if($this->data->approved_comments == 1)
			{
				echo '1 Comment';
			}			
			else
			{
				echo $this->data->approved_comments . ' Comments';
			}
			?>
		</li>
		<li>		
			<?php if($this->data->total_users == 1)
			{
				echo '1 User';
			}
			else
			{
				echo $this->data->total_users . ' Users';
			}
			?>
		</li>
	</ul>
</div>
<!-- Geeky details about the current release -->
<div class='dashboard_box' id='release_box'>
	<h3>PyroCMS Info</h3>
	<ul class='dashboard_list' id='release_list'>
		<li>Version: <?php echo CMS_VERSION; ?></li>
		<li>Release Date: <?php echo CMS_DATE; ?></li>
	</ul>
</div>
<div class='dashboard_box' id='contact_box'>
	<h3>Contact Information</h3>
	<ul class='dashboard_list' id='contact_list'>
		<li><a href="http://www.pyrocms.com/" title="PyroCMS website">Main website</a></li>
		<li><a href="http://github.com/philsturgeon/pyrocms/issues" title="PyroCMS Bugtracker">Public Bugtracker</a></li>
		<li></li>
	</ul>
</div>
<div class='clear'></div>
<!-- Delicious, home baked RSS feeds. -->
<div class='dashboard_box' id='feeds_box'>
	<h3>RSS Feeds</h3>
	<ul class='dashboard_list' id='feeds_list'>
		<?php foreach($this->data->rss_items as $rss_item): ?>
		<li class='rss_item'>
			<strong class='item_name'><a href="<?php echo $rss_item->get_permalink(); ?>"><?php echo $rss_item->get_title(); ?></a></strong>
			<p class='item_date'><?php echo $rss_item->get_date(); ?></p>
			<p class='item_body'><?php echo $rss_item->get_description(); ?></p>
		</li>
		<?php endforeach; ?>
	</ul>
</div>
<div class='clear'></div>