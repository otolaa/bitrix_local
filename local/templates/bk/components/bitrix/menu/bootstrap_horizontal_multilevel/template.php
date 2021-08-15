<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!empty($arResult)):?>
<ul class="navbar-nav ml-auto mr-md-3">
<? $previousLevel = 0;
foreach($arResult as $arItem):?>
	<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
		<?=str_repeat("</div></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
	<?endif?>
	<?if ($arItem["IS_PARENT"]):?>
		<?if ($arItem["DEPTH_LEVEL"] == 1):?>
			<li class="dropdown hidden-sm nav-item"><a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown"><?=$arItem["TEXT"]?> <b class="caret"></b></a>
				<div class="dropdown-menu dropdown-menu-right">
		<?else:?>
			<li class="dropdown hidden-sm nav-item"><a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown"><?=$arItem["TEXT"]?> <b class="caret"></b></a>
				<div class="dropdown-menu dropdown-menu-right">
		<?endif?>
	<?else:?>
		<?if ($arItem["PERMISSION"] > "D"):?>
			<?if ($arItem["DEPTH_LEVEL"] == 1):?>
                <? $arr_class_ = ['nav-item']; // танцы с class
                   if($arItem["SELECTED"]){ $arr_class_[] = "active"; }
                   if($arItem['PARAMS']['CLASS']){ $arr_class_[] = trim($arItem['PARAMS']['CLASS']); } ?>
				<li <?=(count($arr_class_)>0?' class="'.implode(" ",$arr_class_).'"':'')?>><a class="nav-link" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
			<?else:?>
                <? $arr_class_ = ['nav-item']; // танцы с class
                if($arItem["SELECTED"]){ $arr_class_[] = "item-selected active"; }
                if($arItem['PARAMS']['CLASS']){ $arr_class_[] = trim($arItem['PARAMS']['CLASS']); } ?>
				<a class="dropdown-item" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a>
			<?endif?>
		<?else:?>
			<?if ($arItem["DEPTH_LEVEL"] == 1):?>
				<li <?echo $arItem["SELECTED"]?' class="active"':''?>><a class="nav-link" href="" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a></li>
			<?else:?>
				<a href="" class="denied dropdown-item" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a>
			<?endif?>
		<?endif?>
	<?endif?>
	<?$previousLevel = $arItem["DEPTH_LEVEL"];?>
<?endforeach?>
<?if ($previousLevel > 1): //close last item tags ?>
	<?=str_repeat("</div></li>", ($previousLevel-1) );?>
<?endif?>
</ul>
<?endif?>