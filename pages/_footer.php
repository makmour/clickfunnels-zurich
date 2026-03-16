<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<div class="copyrightInfo">
    <p>
        <strong style="float: right;font-weight: 600;font-size: 11px;text-align: right;">
            Running Version <?php echo defined('SUDOWP_CF_ZURICH_VERSION') ? SUDOWP_CF_ZURICH_VERSION : '0.1.0'; ?>
        </strong> 
        Copyright <?php echo date("Y"); ?>+ &copy; SudoWP
    </p>
</div>
<style>
	.copyrightInfo {
		width: 740px;
		padding: 10px 20px;
		padding-top: 0;
		float: left;
		background: #F6F9FB;
		/* box-shadow: 2px 2px 2px #DDEBF5; */
		border-bottom-left-radius: 4px;
		border-bottom-right-radius: 4px;
		/* border: 1px solid #F6F9FB; */
		border: 1px solid #E4E2E2;
		border-top: none;
		color: #074E81;
		margin-left: -1px;
		font-size: 11px;
	}
	.copyrightInfo p {
	    font-size: 11px;
	}
</style>