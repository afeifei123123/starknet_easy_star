<?php

/**
 * 获取当前选中的链接
 * @param string $name 链接名称
 * @return string
 */
function getActive($name)
{
    $url = $_SERVER['PHP_SELF'];
    $url = explode('/', $url);
    $url = $url[count($url) - 1];
    return $url == $name ? 'active' : '';
}

function noticeHtml($show = true, $text = '')
{

    $text = str_replace(' ', '&nbsp;', $text);
    $text = preg_replace('/\b(https?:\/\/[\w\-\.\/]+)\b/', '<a href="$1" target="_blank">$1</a>', $text);
    if ($show) {
        return '<div class="notice"><i class="layui-icon layui-icon-about"></i> ' . $text . '<i class="layui-icon layui-icon-close"></i></div><div class="fill"></div>';
    }
    return '';
}
?>
<?php echo noticeHtml($web->sys['notice_state'], $web->sys['notice_text']); ?>
<div class="header">
    <div class="main">
        <div class="box">
            <a href="index.php">
                <div class="logo">
                    <img src="./images/logo.png?v=<?php echo $web->v; ?>" />
                    <div class="text">
                        <div class="title"><?php echo $web->sys['title']; ?></div>
                        <div class="desc"><?php echo $web->sys['Keywords']; ?></div>
                    </div>
                </div>
            </a>
            <div class="nav">
                <a href="index.php" class="<?php echo getActive('index.php'); ?>">
                    <span>HOME</span>
                    <span class="en">HOME</span>
                </a>
                <a href="price.php" class="<?php echo getActive('price.php'); ?>">
                    <span>Starknet Gas </span>
                    <span class="en">Starknet Gas </span>
                </a>
                <a href="compare.php" class="<?php echo getActive('compare.php'); ?>">
                    <span>AVNU Gas Track</span>
                    <span class="en">AVNU Gas Track</span>
                </a>
                <a href="wait.php" class="<?php echo getActive('wait.php'); ?>">
                    <span>NFT Track </span>
                    <span class="en">NFT Track</span>
                </a>
                <a href="news.php?cid=9" class="<?php echo getActive('news.php'); ?>">
                    <span>Market Track</span>
                    <span class="en">Market Track</span>
                </a>
                <a href="app.php" class="<?php echo getActive('app.php'); ?>">
                    <span>Starknet Dapp</span>
                    <span class="en">Starknet Dapp</span>
                </a>
                <a href="https://community.starknet.io/" class="<?php echo getActive('url.php'); ?>" target="_blank">
                    <span>Starknet Community</span>
                    <span class="en">Starknet Community</span>
                </a>
            </div>
            <div class="game-box">
                <button type="button" class="layui-btn layui-bg-blue layui-btn-radius">Connect Wallet</button>
            </div>
        </div>
    </div>
</div>
<script>
    (() => {
        // 关闭公告
        layui.$('.notice .layui-icon-close').click(function() {
            layui.$('.notice').hide();
            layui.$('.fill').hide();
        });
        
        // 游戏按钮
        layui.$('.game-box ').click(function() {
            layer.open({
                type: 1,
                area: ['500px', 'auto'],
                title: 'connect a wallet',
                shade: 0.6,
                shadeClose: true,
                maxmin: false,
                anim: 0,
                content: `
                <div class="game-list">
                    <div>
                        <button class="layui-btn layui-btn-primary layui-border layui-btn-fluid">
                            <img src="../images/braavos.png" />
                            <span>Install Braavos</span>
                        </button>
                    </div>
                    <div>
                        <button class="layui-btn layui-btn-primary layui-border layui-btn-fluid">
                            <img src="../images/argentx.png" />
                            <span>Install Argent X</span>
                        </button>
                    </div>
                </div>`
            });
        });
        
    })();
</script>