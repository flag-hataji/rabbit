
 
-- メール一括配信システム DB
 

-------------------------------------------------
--  プランマスタ
-------------------------------------------------

DROP TABLE    tm_plan;
DROP SEQUENCE tm_plan_seq;

CREATE TABLE tm_plan (
  plan_id         int4 DEFAULT NEXTVAL('tm_plan_seq') PRIMARY KEY,
  plan            text NOT NULL,           -- プラン名
  price_first     int4 NOT NULL,           -- 初期設定費
  price_month     int4 NOT NULL,           -- 価格(1ヶ月)
  price_month6    int4 NOT NULL,           -- 価格(6ヶ月)
  price_year      int4 NOT NULL,           -- 価格(1年)
  send_max        int4 NOT NULL,           -- 最大メール送信数
  month_max       int4 NOT NULL,           -- 一月の最大メール送信回数
  comment         text,                    -- 備考
  flag_open       int2 NOT NULL DEFAULT 1, -- 募集フラグ：0=募集停止, 1=募集中
  date_update     timestamp DEFAULT now()  -- 更新日
);

-- シーケンスの作成
CREATE SEQUENCE tm_plan_seq START 4;

-- 権限の設定
GRANT ALL ON tm_plan     TO pgsql ;
GRANT ALL ON tm_plan_seq TO pgsql ;
INSERT INTO tm_plan VALUES(1,'無料お試しプラン', 5000,    0,     0,     0,    60, 3, '', 0);
INSERT INTO tm_plan VALUES(2,'ライトプラン',           5000, 1000,  6000, 12000,  6000, 2, 'なんといっても業界最安値の月額1050円！\n１通あたりは0.16円ですがこれで十分な方も多いはず。\n月の配信数がわからない方はまずはライトプランからどうぞ', 1);
INSERT INTO tm_plan VALUES(3,'スタンダードプラン',     5000, 2000, 12000, 24000, 25000, 5, '１通あたり0.08円。\nライトプランでは物足りないお客様へ\n余裕の配信件数のプランです。', 1);
INSERT INTO tm_plan VALUES(4,'エキスパートプラン',     5000, 5000, 30000, 60000, 70000, 5, '１通あたり0.07円と大変お得！\n規模の大きい配信をご希望の場合はコレ！', 1);
INSERT INTO tm_plan VALUES(5,'カスタムプラン',      0,    0,     0,     0,     0, 1, '', 0);
INSERT INTO tm_plan VALUES(6,'サービスプラン',      0,    0,     0,     0,  1000, 1, '', 0);

INSERT INTO tm_plan VALUES(7,'3000円使いきりプラン',2858,    0,     0,     0,  6000, 1, '・税込み3,000円ポッキリで6,000通の配信が可能！\n・初期費用3000円以外の料金は発生いたしません。\n・使用できる機能に制限はありません！ \n・6,000通の配信期間の制限はありません！使い切るまでご使用可能です。\n・「イベントの前の一定期間だけ配信したい」といった方に最適です。\n・6000通配信後に、再度3000円プランに申し込んでいただくことも可能です。', 1);

