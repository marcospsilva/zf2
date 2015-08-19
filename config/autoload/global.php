<?php



return array(
   'db'=>array(
      'driver'=>  'Pdo',
       'dsn'=>'mysqli:dbname=curso_zf2;host=localhost',
       /*'driver_options'=>array(
           PDO::MYSQLI_ATTR_INIT_COMMAND=>'SET NAMES "UTF8"'

       )*/
   ),
    /*
     * Configurand o serviço para toda a aplicação
     */
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory'
        )
    )
);
