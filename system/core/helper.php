<?php
/**
 * =================================================
 * BBStandards Working Group : SocialBoard Standard
 * -------------------------------------------------
 * Copyright (c) 2014, CreationShare Technology LLC
 * Published under the terms of the MIT License
 * =================================================
 */

class AdminHelper {
	public static function buildMenuItem($link, $icon, $text) {
		return "<div class='admin-menu-item'><a href='admin/$link/'><div class='admin-menu-item-icon'><img src='system/public/".$icon.".png' /></div><div class='admin-menu-item-text'>$text</div></a></div>";
	}
}