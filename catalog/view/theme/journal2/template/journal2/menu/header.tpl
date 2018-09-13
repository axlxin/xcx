<?php foreach ($items as $item): ?>
<?php if ($item['href']): ?>

    <?php if($this->customer->isLogged() && $item['menu_item_page']=='account/account'){ ?>
    <div id="account-dropdown-group" class="menu-item-group">
    <a href="<?php echo $item['href']; ?>" <?php echo $item['class']; ?><?php echo $item['target']; ?>><?php echo $item['icon_left']; ?><span class="top-menu-link"><?php echo $item['name']; ?></span><?php echo $item['icon_right']; ?></a>
    <ul class="dropdown-menu" id='account-dropdown-menu'>
        <li><a href='index.php?route=account/account'>My Account</a></li>
        <li><a href='index.php?route=account/order'>Order History</a></li>
        <li><a href='index.php?route=account/reward'>Reward Points</a></li>
        <li><a href='index.php?route=account/logout'>Logout</a></li>
    </ul>
    </div>
    <?php } else { ?>
    <a href="<?php echo $item['href']; ?>" <?php echo $item['class']; ?><?php echo $item['target']; ?>><?php echo $item['icon_left']; ?><span class="top-menu-link"><?php echo $item['name']; ?></span><?php echo $item['icon_right']; ?></a>
    <?php } ?>
<?php else: ?>
<span <?php echo $item['class']; ?><?php echo $item['target']; ?>><?php echo $item['icon_left']; ?><?php echo $item['name']; ?><?php echo $item['icon_right']; ?></span>
<?php endif; ?>
<?php endforeach; ?>