<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<ul class="nav navbar-nav">

<?
$previousLevel = 0;
foreach($arResult as $arItem):?>

	<?if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):?>
		<?=str_repeat("</ul></li>", ($previousLevel - $arItem["DEPTH_LEVEL"]));?>
	<?endif?>

	<?if ($arItem["IS_PARENT"]):?>

		<?if ($arItem["DEPTH_LEVEL"] == 1):?>
			<li class="dropdown hidden-sm"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=$arItem["TEXT"]?> <b class="caret"></b></a>
				<ul class="dropdown-menu">
		<?else:?>
			<li class="dropdown hidden-sm"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=$arItem["TEXT"]?> <b class="caret"></b></a>
				<ul class="dropdown-menu">
		<?endif?>

	<?else:?>

		<?if ($arItem["PERMISSION"] > "D"):?>
            <? /**/  ?>

			<?if ($arItem["DEPTH_LEVEL"] == 1):?>
                <? $arr_class_ = array(); // танцы с class
                   if($arItem["SELECTED"]){ $arr_class_[] = "active"; }
                   if($arItem['PARAMS']['CLASS']){ $arr_class_[] = trim($arItem['PARAMS']['CLASS']); } ?>
				<li <?=(count($arr_class_)>0?' class="'.implode(" ",$arr_class_).'"':'')?>><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
			<?else:?>
                <? $arr_class_ = array(); // танцы с class
                if($arItem["SELECTED"]){ $arr_class_[] = "item-selected active"; }
                if($arItem['PARAMS']['CLASS']){ $arr_class_[] = trim($arItem['PARAMS']['CLASS']); } ?>
				<li <?=(count($arr_class_)>0?' class="'.implode(" ",$arr_class_).'"':'')?>><a href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>
			<?endif?>

		<?else:?>

			<?if ($arItem["DEPTH_LEVEL"] == 1):?>
				<li <?echo $arItem["SELECTED"]?' class="active"':''?>><a href="" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a></li>
			<?else:?>
				<li><a href="" class="denied" title="<?=GetMessage("MENU_ITEM_ACCESS_DENIED")?>"><?=$arItem["TEXT"]?></a></li>
			<?endif?>

		<?endif?>

	<?endif?>

	<?$previousLevel = $arItem["DEPTH_LEVEL"];?>

<?endforeach?>

<?if ($previousLevel > 1): //close last item tags ?>
	<?=str_repeat("</ul></li>", ($previousLevel-1) );?>
<?endif?>

</ul>
<div class="menu-clear-left"></div>
<?endif?>