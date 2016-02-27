	<?php
		class lms_user_nav {
			protected $nav;
			
			public function __construct ( $array ) {
				$this->nav = $array;
			}
			
			protected function nav_array () {
				if ( ! is_array ( $this->nav ) ):
					return array();
				else:
					return $this->nav;
				endif;
			}
			
			protected function menus () {
				foreach ( $this->nav as $key=>$elements ):
					if ( ! is_array ( $elements ) ) :
						
			}
			public function lms_user_navigation() {
				return $this->menu();

			}
		}
	?>