## Primeiros passos com Symfony

#### Instalação
Instalar apenas o necessário para funcionar

`composer create-project symfony/skeleton pasta-destino`

Instalação completa

`composer create-project symfony/website-skeleton pasta-destino`

#### Chamar o maker para gerar arquivos
Dentro da pasta onde o symfony foi instalado o 
maker pode ser chamado pelo comando

`php bin/console make:`

depois dos `:` podem ser inseridos os 
seguintes comandos: 
      
`:command`                
`:controller`             
`:crud`                   
`:entity`                 
`:fixtures`               
`:form`                   
`:functional-test`        
`:migration`              
`:registration-form`      
`:serializer:encoder`     
`:serializer:normalizer`  
`:subscriber`             
`:twig-extension`         
`:unit-test`              
`:user`                   
`:validator`              
`:voter`       

#### Atualizar mudanças no banco de dados - Entidades Mapeadas com Doctrine
Comando para gerar as migrations (ainda não atualiza o BD)
Apenas gera a difernça entre como o banco estava e
como deveria estar agora.

`php bin/console doctrine:migration:diff`

O comando acima gera um arquivo em `src/Migrations`
coms as diferanças entre os bancos (Faz versionamento)

Para atualizar o banco a partir das migrations geradas

`php bin/console doctrine:migration:migrate`