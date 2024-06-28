<?php
declare(strict_types=1);

use Elastic\Adapter\Indices\Mapping;
use Elastic\Adapter\Indices\Settings;
use Elastic\Migrations\Facades\Index;
use Elastic\Migrations\MigrationInterface;

final class TuraqCharacteristicsIndex implements MigrationInterface
{
    /**
     * Run the migration.
     */
    public function up(): void
    {
        Index::create('turaq_characteristics_index', function (Mapping $mapping, Settings $settings) {
            $mapping->keyword('id');
            $mapping->text('title');
            $mapping->boolean('is_active');

            $settings->index([
                'number_of_replicas' => 2,
            ]);

            $settings->analysis([
                'filter' => [
                    'main_stopwords' => [
                        'type' => 'stop',
                        'stopwords' => 'а,без,более,бы,был,была,были,было,быть,в,вам,вас,весь,во,вот,все,всего,всех,вы,где,да,даже,для,до,его,ее,если,есть,еще,же,за,здесь,и,из,или,им,их,к,как,ко,когда,кто,ли,либо,мне,может,мы,на,надо,наш,не,него,нее,нет,ни,них,но,ну,о,об,однако,он,она,они,оно,от,очень,по,под,при,с,со,так,также,такой,там,те,тем,то,того,тоже,той,только,том,ты,у,уже,хотя,чего,чей,чем,что,чтобы,чье,чья,эта,эти,это,я,a,an,and,are,as,at,be,but,by,for,if,in,into,is,it,no,not,of,on,or,such,that,the,their,then,there,these,they,this,to,was,will,with'
                    ]
                ],
                'analyzer' => [
                    'title' => [
                        'type' => 'custom',
                        'tokenizer' => 'whitespace',
                        'filter' => ['main_stopwords']
                    ]
                ]
            ]);
        });
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        Index::dropIfExists('turaq_characteristics_index');
    }
}
