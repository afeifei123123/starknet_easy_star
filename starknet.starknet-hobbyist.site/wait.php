<?php
include './admin/php/api.php';
class wait extends _api
{
    public function _table()
    {
        $data = [[
            'name' => 'The Crown of Stark',
            'type' => 'Starkpunks',
            'img' => '../images/img-1.png?v=1',
            'price' => '0',
            '1h' => -1.01,
            '2h' => 2.6,
            '7d' => 6.9,
            'volume' => '41,775,212',
            'marketcap' => '360,828,478,200',
            'starknet_tvl' => '144,279,381'
        ], [
            'name' => 'Starknet.id',
            'type' => 'ETH',
            'img' => '../images/img-2.png?v=1',
            'price' => '0',
            '1h' => -1.01,
            '2h' => 2.6,
            '7d' => 6.9,
            'volume' => '41,775,212',
            'marketcap' => '360,828,478,200',
            'starknet_tvl' => '144,279,381'
        ], [
            'name' => 'Starkpunks',
            'type' => 'ETH',
            'img' => '../images/img-3.png?v=1',
            'price' => '0',
            '1h' => -1.01,
            '2h' => 2.6,
            '7d' => 6.9,
            'volume' => '41,775,212',
            'marketcap' => '360,828,478,200',
            'starknet_tvl' => '144,279,381'
        ], [
            'name' => 'Xplorer',
            'type' => 'ETH',
            'img' => '../images/img-4.png?v=1',
            'price' => '0',
            '1h' => -1.01,
            '2h' => 2.6,
            '7d' => 6.9,
            'volume' => '41,775,212',
            'marketcap' => '360,828,478,200',
            'starknet_tvl' => '144,279,381'
        ], [
            'name' => 'Starknet Quest',
            'type' => 'ETH',
            'img' => '../images/img-5.png?v=1',
            'price' => '0',
            '1h' => -1.01,
            '2h' => 2.6,
            '7d' => 6.9,
            'volume' => '41,775,212',
            'marketcap' => '360,828,478,200',
            'starknet_tvl' => '144,279,381'
        ], [
            'name' => 'StarkRock',
            'type' => 'ETH',
            'img' => '../images/img-6.png?v=1',
            'price' => '0',
            '1h' => -1.01,
            '2h' => 2.6,
            '7d' => 6.9,
            'volume' => '41,775,212',
            'marketcap' => '360,828,478,200',
            'starknet_tvl' => '144,279,381'
        ], [
            'name' => 'Briq',
            'type' => 'ETH',
            'img' => '../images/img-7.png?v=1',
            'price' => '0',
            '1h' => -1.01,
            '2h' => 2.6,
            '7d' => 6.9,
            'volume' => '41,775,212',
            'marketcap' => '360,828,478,200',
            'starknet_tvl' => '144,279,381'
        ]];

        $json = [
            'code' => 0,
            'msg' => '',
            'count' => count($data),
            'data' => $data
        ];
        echo json_encode($json, JSON_UNESCAPED_UNICODE);
    }
};
$web = new wait(1);
$web->method('');
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>
        NTF Track
    </title>
    <meta name="renderer" content="webkit" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <link rel="stylesheet" href="https://www.layuicdn.com/layui/css/layui.css?v=<?php echo $web->v; ?>" />
    <link rel="stylesheet" type="text/css" href="../css/style.css?v=<?php echo $web->v; ?>" />
    <script src="https://www.layuicdn.com/layui/layui.js?v=<?php echo $web->v; ?>"></script>
    <style>
        .chief {
            text-align: center;
        }

        .chief .desc {
            height: auto;
        }

        .layui-table-box .info {
            display: flex;
            align-items: center;
            line-height: 20px;
        }

        .layui-table-box .info .img {
            width: 28px;
            height: 28px;
            margin-right: 10px;
        }

        .layui-table-box .info .img img {
            width: 100%;
            height: 100%;
        }

        .layui-table-box .info .text {
            flex: 1;
            width: calc(100% - 38px);
        }

        .layui-table-box .info .text .name {
            font-size: 16px;
            font-weight: bold;
        }


        .data-up {
            color: #2dca93;
            margin-left: 5px;
            font-size: 12px;
        }

        .data-up::before {
            content: "";
            display: inline-block;
            width: 0;
            height: 0;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            border-bottom: 8px solid #2dca93;
            margin-right: 5px;
        }

        .data-down {
            color: #fc6772;
            margin-left: 5px;
            font-size: 12px;
        }

        .data-down::before {
            content: "";
            display: inline-block;
            width: 0;
            height: 0;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            border-top: 8px solid #fc6772;
            margin-right: 5px;
        }

        .data-equality {
            color: #5191FF;
            margin-left: 5px;
            font-size: 12px;
        }

        .data-equality::before {
            content: "";
            display: inline-block;
            width: 7px;
            height: 5px;
            background-color: #5191FF;
            margin-right: 5px;
        }

        .layui-table {
            background-color: transparent;
        }

        .layui-table td,
        .layui-table th,
        .layui-table-col-set,
        .layui-table-fixed-r,
        .layui-table-grid-down,
        .layui-table-header,
        .layui-table-mend,
        .layui-table-page,
        .layui-table-tips-main,
        .layui-table-tool,
        .layui-table-total,
        .layui-table-view,
        .layui-table[lay-skin=line],
        .layui-table[lay-skin=row] {
            border-color: #333333;
        }

        .layui-table-view .layui-table td,
        .layui-table-view .layui-table th span {
            color: rgb(160, 165, 204);
        }

        .search {
            margin-top: 80px;
            margin-bottom: 50px;
            background-color: #1e1e50;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .layui-table-click,
        .layui-table-hover,
        .layui-table[lay-even] tbody tr:nth-child(even) {
            background-color: #1e1e50;
        }
    </style>
</head>

<body>
    <?php include './header.php'; ?>
    <div class="chief">
        <div class="main">
            <div class="title">NFT Track（cooming soon....）</div>
            <div class="desc">Our next development content:
                NFT Tarck
                On the NTF aggregator on starknet, we will track and collect data from the Element Market, Unframed, FLEX, Pyramid, and four starknet NFT markets. To provide users of Starknet NFT trading with the most comprehensive NFT data analysis and trading, mainly including real-time and latest floor prices, historical transaction volumes, depth of historical sell orders, ranking of NFT trading volume on the Starknet network, and tracking of Starknet NFT whale trading.</div>
        </div>
    </div>
    <div class="content">
        <div class="main">
            <div class="search">
                <input type="text" class="layui-input" placeholder="Search for NFT" name="key" />
                <button class="layui-btn layui-bg-blue">
                    <i class="layui-icon layui-icon-search"></i>
                    <span>Search</span>
                </button>
            </div>
            <div id="table"></div>
            <div style="height:100px;"></div>
        </div>
    </div>
    <?php include './footer.php'; ?>
</body>
<script>
    window.layui.table.render({
        elem: '#table',
        page: true,
        title: 'table',
        skin: 'line',
        size: 'lg',
        toolbar: false,
        defaultToolbar: [],
        page: false,
        url: './wait.php?method=table',
        cols: [
            [{
                    field: 'index',
                    title: ' ',
                    type: 'numbers',
                    width: 60
                }, {
                    field: 'name',
                    title: 'NAME',
                    width: 200,
                    templet: d => {
                        return `<div class="info">
                                    <div class="img">
                                        <img src="${d.img}" alt="">
                                    </div>
                                    <div class="text">
                                        <div class="name">${d.name}</div>
                                    </div>
                        </div>`;
                    }
                }, {
                    field: 'price',
                    title: 'Floor price',
                    width: 150,
                    align: 'right',
                    sort: true,
                    templet: d => {
                        return '$' + d.price;
                    }
                },
                {
                    field: '1h',
                    title: '1day',
                    width: 120,
                    sort: true,
                    templet: d => {
                        if (d['1h'] < 0) {
                            return `<span class="data-down">${-d['1h']}%</span>`;
                        } else if (d['1h'] == 0) {
                            return `<span class="data-equality">${d['1h']}%</span>`;
                        } else {
                            return `<span class="data-up">${d['1h']}%</span>`;
                        }
                    }
                },
                {
                    field: '2h',
                    title: '3day',
                    width: 120,
                    sort: true,
                    templet: d => {
                        if (d['2h'] < 0) {
                            return `<span class="data-down">${-d['2h']}%</span>`;
                        } else if (d['2h'] == 0) {
                            return `<span class="data-equality">${d['2h']}%</span>`;
                        } else {
                            return `<span class="data-up">${d['2h']}%</span>`;
                        }
                    }
                },
                {
                    field: '7d',
                    title: '7day',
                    width: 120,
                    sort: true,
                    templet: d => {
                        if (d['7d'] < 0) {
                            return `<span class="data-down">${-d['7d']}%</span>`;
                        } else if (d['7d'] == 0) {
                            return `<span class="data-equality">${d['7d']}%</span>`;
                        } else {
                            return `<span class="data-up">${d['7d']}%</span>`;
                        }
                    }
                },
                {
                    field: 'volume',
                    title: 'Trading volume(24H)	',
                    width: 220,
                    align: 'right',
                    sort: true,
                    templet: d => {
                        return '$' + d.price;
                    }
                }, {
                    field: 'marketcap',
                    title: 'Market Cap',
                    width: 200,
                    align: 'right',
                    sort: true,
                    templet: d => {
                        return '$' + d.price;
                    }
                }, {
                    field: 'starknet_tvl',
                    title: 'Hodler',
                    minWidth: 200,
                    align: 'right',
                    sort: true,
                    templet: d => {
                        return '$' + d.price;
                    }
                }
            ]
        ]
    });
</script>

</html>