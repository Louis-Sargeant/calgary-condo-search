<?php
if (!defined('ABSPATH')) {
    exit;
}

final class Calgary_Condo_Chat_Widget {
    public function __construct() {
        add_action('wp_footer', [$this, 'render_tawk_widget'], 50);
    }

    public function render_tawk_widget(): void {
        if (is_admin()) {
            return;
        }
        ?>
        <!--Start of Tawk.to Script-->
        <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/6a31f58d16fcef1d436f9f4c/1jr9iecj1';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
        })();
        </script>
        <!--End of Tawk.to Script-->
        <?php
    }
}

new Calgary_Condo_Chat_Widget();
