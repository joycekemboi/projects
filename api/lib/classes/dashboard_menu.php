	<?php
		class dashboard_menu {
			protected $menu; 
			
			protected function dashboard_menu_array () {
				require_once ( USER_ABSPATH . TEMPLATES . 'dashboard-menu.php' );
				return $this->menu = $dashboard;
			}
			protected function construct_dashboard_menu () {
				$menus = $this->dashboard_menu_array ();
				if ( ! is_array ( $menus ) ):
					return false;
				else:
					$menu = '';
					if ( ! isset ( $_GET['module'] ) ):
						$pg = 'general';
					else:
						$pg = clean_get_url ( $_GET['module'] );
					endif;
					
					foreach ( $menus as $title=>$sections ):
						$parts = explode ( '|', $sections );
						$link = $parts[0];
						$icon = $parts[1];
						$class = ( $pg == $link ) ? 'current' : '';
						$menu .= '<a class="context-menu-item-holder ' . $class . '" href="' . USER_DOMAIN . $link . '">
						<i class="fa ' . $icon . '"></i>
						<span>' . $title . '</span>
						</a>';
					endforeach;
						return $menu;
				endif;
			}
			
			public function lms_dashboard_menu () {				
				return $this->construct_dashboard_menu ();
			} 
		}
	?>