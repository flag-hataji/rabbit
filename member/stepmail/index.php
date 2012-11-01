<?PHP ini_set("display_errors",1); require_once("../../program/cls/define/Setup.php");?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=EUC-JP">
<META HTTP-EQUIV="Content-Style-Type" CONTENT="text/css">
<script language="JavaScript" src="https://secure.comodo.net/trustlogo/javascript/trustlogo.js" type="text/javascript"></script>
<link href="../../../common/css/common.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
<!--
<?PHP require_once(_DIR_USER_HTML_._HTML_JS_); ?>
//-->
</script>
<title>ステップメールメニュートップ</title>
</head>

<body  bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div align='center'>
	<table width="900" border="0" cellspacing="0" cellpadding="0" bgcolor='#FFFFFF'>
		<tr> 
			<td width="10" background="<?PHP echo _RELATIVE_; ?>common/image/shadow_left.gif"><img src='<?PHP echo _RELATIVE_; ?>common/image/spacer.gif' width='1' height='1' ></td>
			<td width='1' bgcolor='#FFFFFF'><img src='<?PHP echo _RELATIVE_; ?>common/image/spacer.gif' width='1' height='1' ></td>
		  <td align='center' bgcolor='#FFFFFF'>
<!-- HEADER -->
<?PHP require_once(_DIR_USER_HTML_._HTML_HEADER_); ?>
<!-- BODY -->
				<table width="850" border="0" cellspacing="0" cellpadding="0" bgcolor='#948E8E'>
					<tr class='gray10'> 
<!-- BODY LEFT -->
					  <td width='152' align='center' valign='top' bgcolor='#FFFFFF'><?PHP require_once(_DIR_USER_HTML_._HTML_LEFT_MENU_); ?>
                        <br>
                        <br>
</td>
						<td width='5' bgcolor='#FFFFFF'><img src='<?PHP echo _RELATIVE_; ?>common/image/spacer.gif' width='5' height='1' ></td>
						<td width='1' bgcolor='#FFFFFF' background='<?PHP echo _RELATIVE_; ?>common/image/y_comma.gif'><img src='<?PHP echo _RELATIVE_; ?>common/image/spacer.gif' width='1' height='1' ></td>
						<td width='5' bgcolor='#FFFFFF'><img src='<?PHP echo _RELATIVE_; ?>common/image/spacer.gif' width='5' height='1' ></td>
<!-- BODY CENTER -->
						<td width='100%' align='center' valign='top' bgcolor='#FFFFFF'> 
<!-- write area start -->
	<table  border="0" cellpadding='0' cellspacing='0' width="100%" >
		<tr> 
			<td class='indigo12' valign='top' align='left'><img src='<?PHP echo _RELATIVE_; ?>common/image/mark_square.gif'> 
				<b>ステップメールメニュー
			</td>
			<td class='indigo12' valign='top' align='right'></td>
		</tr>
		<tr>
			<td width='1' height='5' bgcolor='#FFFFFF' colspan='2'><img src='<?PHP echo _RELATIVE_; ?>common/image/spacer.gif' width='1' height='5' ></td>
		</tr>
	</table>
	<table width="100%" border="0" cellpadding='5' cellspacing='1' bgcolor='#666666'>
		<tr>
			<td colspan="3" align='left' class='black12'  bgcolor='#FFFFFF'>
				<table  border="0" cellpadding='0' cellspacing='0' width="100%" >
					<tr> 
						<td width='1' height='10' bgcolor='#FFFFFF'><img src='<?PHP echo _RELATIVE_; ?>common/image/spacer.gif' width='1' height='10' ></td>
					</tr>
					<tr> 
						<td class='braun14' valign='top' align='left'><img src='<?PHP echo _RELATIVE_; ?>common/image/mark_square_2.gif'> 
							<b><a href="user/index.php">配信ユーザー管理（リスト管理）</a><b>						</td>
					</tr>
					<tr> 
						<td height='1' bgcolor='#FFFFFF' background='<?PHP echo _RELATIVE_; ?>common/image/x_comma.gif'><img src='<?PHP echo _RELATIVE_; ?>common/image/spacer.gif' height='1' ></td>
					</tr>
					<tr> 
						<td width='1' height='5' bgcolor='#FFFFFF'><img src='<?PHP echo _RELATIVE_; ?>common/image/spacer.gif' width='1' height='5' ></td>
					</tr>
					<tr> 
						<td class='black12' valign='top' align='left'><br>
							<ul>
							<li>ステップメールを配信するユーザーリストを管理します。</li>
							<li>まずはここでユーザーを追加してください。</li>
							<li>配信ユーザーの追加、修正、削除、検索、ステップの振り分け、配信スタート、ストップ、リストダウンロードなどができます。</li>
						    </ul>						</td>
					</tr>
					<tr> 
						<td width='1' height='10' bgcolor='#FFFFFF'>
						<img src='<?PHP echo _RELATIVE_; ?>common/image/spacer.gif' width='1' height='15' ></td>
					</tr>
					<tr> 
						<td class='braun14' valign='top' align='left'>
							<img src='<?PHP echo _RELATIVE_; ?>common/image/mark_square_2.gif'> 
							<b><a href="scenario/index.php">シナリオ、ステップ管理（メール管理）</a><b>						</td>
					</tr>
					<tr> 
						<td height='1' bgcolor='#FFFFFF' background='<?PHP echo _RELATIVE_; ?>common/image/x_comma.gif'><img src='<?PHP echo _RELATIVE_; ?>common/image/spacer.gif' height='1' ></td>
					</tr>
					<tr> 
						<td width='1' height='5' bgcolor='#FFFFFF'><img src='<?PHP echo _RELATIVE_; ?>common/image/spacer.gif' width='1' height='5' ></td>
					</tr>
					<tr> 
						<td class='black12' valign='top' align='left'><br>
						  <ul>
							<li>配信するメールのシナリオ、ステップなどを管理します。</li>
							<li>登録したステップを何日間隔で配信するか設定します。</li>
							<li>シナリオとステップとは以下のような組み合わせでできています。</li>
				          </ul>
						    <p><strong>シナリオとステップとは？？</strong><br/>
						    シナリオとはいくつかのメールをジャンルわけ下テーマ、ステップはそのメール1通1通を言います。
						    例）<br>　
					        シナリオ１　『化粧品サンプルシナリオ』<br>
					         　　 ・申し込みフォーム入力　　　　　『このたびは化粧品サンプルを申し込みありがとうございます。』 <br>
						      　　
						      ・ステップ１　（２日後配信）　　　『サンプルは届きましたでしょうか？』<br>
						      　　
						      ・ステップ２　（３日後配信）　　　『サンプル化粧品の効果的な使用方法をご説明いたします。』<br>
						      　　
						      ・ステップ３　（７日後配信）　　　『サンプル化粧品の効果は現れましたか？』<br>
						      　　
					        ・ステップ４　（２週間後配信）　　『そろそろ使い切ってしまう頃だと思います。　サンプル者に今なら特別価格でご提供します。』</p>
						    <p>　シナリオ２　『プレゼント応募者シナリオ』　（毎週水曜日配信）<br>
					    　　
						      ・ステップ１　『このたびはプレゼントにご応募いただきありがとうございます。』<br>
						      　　
						      ・ステップ２　『※※※※※※※※※※※※※※※※※※※※※※※※※※』<br>
						      　　
						      ・ステップ３　『▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲▲』<br>
						      <br>
						      <br>
					    </p>					    </td>
					</tr>
					<tr>
                      <td class='braun14' valign='top' align='left'><img src='<?PHP echo _RELATIVE_; ?>common/image/mark_square_2.gif'> <b><a href="form/">ユーザー登録フォーム管理</a><b> </td>
					  </tr>
					<tr>
                      <td height='1' bgcolor='#FFFFFF' background='<?PHP echo _RELATIVE_; ?>common/image/x_comma.gif'><img src='<?PHP echo _RELATIVE_; ?>common/image/spacer.gif' height='1' ></td>
					  </tr>
					<tr>
                      <td height='5' bgcolor='#FFFFFF'><img src='<?PHP echo _RELATIVE_; ?>common/image/spacer.gif' width='1' height='5' ></td>
					  </tr>
					<tr>
                      <td class='black12' valign='top' align='left'><br>
                          <ul>
                            <li>配信ユーザーを登録するためのフォームを管理します。</li>
                            <li>登録したフォームは、リンクで呼び出すか、HTMLタグを自分のホームページに貼り付けることで、利用します。
                              <br>
                        </li>
                          </ul>
                        </td>
					  </tr>
					<tr> 
						<td width='1' height='10' bgcolor='#FFFFFF'>
						<img src='<?PHP echo _RELATIVE_; ?>common/image/spacer.gif' width='1' height='15' ></td>
					</tr>
					<tr> 
						<td class='braun12' valign='top' align='left'>
							<img src='<?PHP echo _RELATIVE_; ?>common/image/mark_square_2.gif'> 
							<b>実装予定</td>
					</tr>
					<tr> 
						<td height='1' bgcolor='#FFFFFF' background='<?PHP echo _RELATIVE_; ?>common/image/x_comma.gif'><img src='<?PHP echo _RELATIVE_; ?>common/image/spacer.gif' height='1' ></td>
					</tr>
					<tr> 
						<td width='1' height='5' bgcolor='#FFFFFF'><img src='<?PHP echo _RELATIVE_; ?>common/image/spacer.gif' width='1' height='5' ></td>
					</tr>
					<tr> 
						<td class='black12' valign='top' align='left'>
							今後の実装予定のロードマップを公開しておきます。ご要望等ありましたら、<a href="/inquiry/">お問合せ</a>よりお願い致します。
							  <ul>
							<li><s>配信曜日間隔設定</s>OK</li>
							<li><s>ユーザー登録フォームの生成プログラム</s>OK</li>
							<li><s>配信停止URL吐き出しプログラムの作成</s>OK</li>
							<li><s>ステップのテスト（現在実行中。日付指定はほぼOK）</s>OK</li>
							<li>ユーザー側ログ閲覧部分の作成</li>
							<li>管理側ログの取得</li>
						</ul>						</td>
					</tr>
					<tr> 
						<td height='1' bgcolor='#FFFFFF' background='<?PHP echo _RELATIVE_; ?>common/image/x_comma.gif'><img src='<?PHP echo _RELATIVE_; ?>common/image/spacer.gif' height='1' ></td>
					</tr>
					<tr>
						<td width='1' height='5' bgcolor='#FFFFFF'><img src='<?PHP echo _RELATIVE_; ?>common/image/spacer.gif' width='1' height='5' ></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

	<table  border="0" cellpadding='0' cellspacing='0' width="485" >
		<tr>
			<td width='1' height='10' bgcolor='#FFFFFF'><img src='<?PHP echo _RELATIVE_; ?>common/image/spacer.gif' width='1' height='10' ></td>
		</tr>
	</table>
<!-- write area end -->
					</tr>
				</table>
<!-- FOOTER -->
<?PHP require_once(_DIR_USER_HTML_._HTML_FOOTER_); ?></td>
			<td width='1' bgcolor='#FFFFFF'><img src='<?PHP echo _RELATIVE_; ?>common/image/spacer.gif' width='1' height='1' ></td>
			<td width="10" background="<?PHP echo _RELATIVE_; ?>common/image/shadow_right.gif"><img src='<?PHP echo _RELATIVE_; ?>common/image/spacer.gif' width='1' height='1' ></td>
		</tr>
	</table>
</div>
</body>
</html>
