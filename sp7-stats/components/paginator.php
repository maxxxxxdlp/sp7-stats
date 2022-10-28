<?php

function show_page($target_page,$link='',$current_page=0){

	static $target_link;
	static $page;

	if($target_page=='' && $link!=='' && $current_page!==0){
		$target_link = $link;
		$page = $current_page;
		return;
	}

	if($target_page == '>'){ ?>
		<li class="page-item"><a
				class="page-link"
				href="<?= $target_link.($page + 1) ?>"><?= $target_page ?></a></li> <?php
	} elseif($target_page == '<') { ?>
		<li class="page-item"><a
				class="page-link"
				href="<?= $target_link.($page - 1) ?>"><?= $target_page ?></a></li> <?php
	} elseif($page == $target_page) { ?>
		<li class="page-item disabled"><a
				class="page-link"
				disabled><?= $target_page ?></a></li> <?php
	} elseif($target_page == '...') { ?>
		<li class="page-item disabled"><a
				class="page-link"
				disabled>...</a></li> <?php
	} else { ?>
		<li class="page-item"><a
				class="page-link"
				href="<?= $target_link.($target_page) ?>"><?= $target_page ?></a></li> <?php
	}

}

function paginator($graph_name,$page,$pages_count){

	if($pages_count <= 1)
		return;

	show_page('',$graph_name,$page); ?>


	<nav
		class="col-12 mt-5">
		<ul class="pagination justify-content-center"> <?php

			if($page != 1 && $pages_count > 1)
				show_page('<');

			if($pages_count <= 5)
				for($i = 1; $i <= $pages_count; $i++)
					show_page($i); else {
				if($page <= 5)
					for($i = 1; $i <= $page; $i++)
						show_page($i); else {
					show_page(1);
					show_page(2);
					show_page('...');
					show_page($page - 1);
					show_page($page);
				}

				if($page + 4 >= $pages_count)
					for($i = $page + 1; $i <= $pages_count; $i++)
						show_page($i); else {
					show_page($page + 1);
					show_page('...');
					show_page($pages_count - 1);
					show_page($pages_count);
				}
			}

			if($page != $pages_count)
				show_page('>');

			?>

		</ul>
	</nav> <?php

}