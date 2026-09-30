[![GitHub license](https://img.shields.io/github/license/fawno/agencias)](https://github.com/fawno/agencias/blob/master/LICENSE)
[![GitHub tag (latest SemVer)](https://img.shields.io/github/v/tag/fawno/agencias)](https://github.com/fawno/agencias/tags)
[![Packagist](https://img.shields.io/packagist/v/fawno/agencias)](https://packagist.org/packages/fawno/agencias)
[![Packagist Downloads](https://img.shields.io/packagist/dt/fawno/agencias)](https://packagist.org/packages/fawno/agencias/stats)
[![GitHub issues](https://img.shields.io/github/issues/fawno/agencias)](https://github.com/fawno/agencias/issues)
[![GitHub forks](https://img.shields.io/github/forks/fawno/agencias)](https://github.com/fawno/agencias/network)
[![GitHub stars](https://img.shields.io/github/stars/fawno/agencias)](https://github.com/fawno/agencias/stargazers)

# Agencias

Cliente PHP tipado para la API de contenidos de Agencia EFE. El proyecto está en desarrollo y, en su estado actual, implementa la autenticación, la consulta de productos contratados, la recuperación de contenidos por producto o formato y la consulta de los catálogos de modelos publicados por EFE.

La implementación sigue los objetos de respuesta descritos en la [documentación oficial de la API de EFE](https://apinews.efeservicios.com/api-documentation/index.html#schemas).

## Requisitos e instalación

- PHP 8.1 o posterior.
- Extensiones requeridas por Composer y Guzzle.

```shell
composer require fawno/agencias
```

## Uso

```php
use Fawno\Agencias\EFEClient;
use Fawno\Agencias\EFE\Format;
use Fawno\Agencias\EFE\FormatRequest;

$efe = EFEClient::create($_ENV['EFE_CLIENT_ID'], $_ENV['EFE_CLIENT_SECRET']);

$products = $efe->getProducts();
$content = $efe->getItemsInFormat(
    Format::TEXTO,
    format: FormatRequest::JSON,
);

$models = $efe->getModels();
$modelName = $models->data->models->first();
$modelValues = $efe->getModelData($modelName);
```

No incluya las credenciales en el repositorio. Cárguelas desde variables de entorno o desde otro almacén de secretos.

### Operaciones disponibles

- `EFEClient::getProducts()`: productos contratados por el cliente.
- `EFEClient::getModels()`: nombres de los catálogos de modelos disponibles en EFE.
- `EFEClient::getModelData()`: valores de uno de esos catálogos, con filtros opcionales de texto y entero.
- `EFEClient::getItemsByProductId()`: contenidos pertenecientes a un producto.
- `EFEClient::getItemsInFormat()`: contenidos filtrados por tipo (texto, fotografía, audio, vídeo, etc.).

Con `FormatRequest::JSON` se devuelve un `ContentResponse` tipado. Los formatos `NEWSML`, `RSS` y `XML` se devuelven como texto sin transformar.

Las fechas de consulta se envían a EFE en UTC. El tamaño de página admitido es de 1 a 500; cualquier otro valor se sustituye por 10.

## Gestión de errores

Todas las excepciones propias heredan de `Fawno\Agencias\EFE\Exception\EFEException`:

- `AuthenticationException`: respuesta HTTP 401, autenticación rechazada.
- `ForbiddenException`: respuesta HTTP 403, por ejemplo un producto no contratado.
- `NotFoundException`: respuesta HTTP 404, que EFE también utiliza cuando no hay resultados o algún parámetro no es válido.
- `TooManyRequestsException`: respuesta HTTP 429, límite de peticiones excedido.
- `HttpException`: cualquier otra respuesta HTTP no exitosa. Expone `statusCode` y `responseBody`.
- `TransportException`: la petición no pudo completarse por un problema de conexión o transporte.

```php
use Fawno\Agencias\EFE\Exception\ForbiddenException;
use Fawno\Agencias\EFE\Exception\NotFoundException;

try {
    $content = $efe->getItemsByProductId(1234);
} catch (NotFoundException) {
    // La consulta no devolvió contenido o sus parámetros no son válidos.
} catch (ForbiddenException) {
    // El producto no está contratado por este cliente.
}
```

El cuerpo devuelto por EFE se conserva en `HttpException::$responseBody`, pero no se incorpora al mensaje de la excepción para evitar revelar información sensible accidentalmente en los logs.

## Modelos

Los DTO bajo `Fawno\Agencias\EFE` representan la envolvente, parámetros, productos, paquetes, objetos de contenido, metadatos, ficheros, propiedades multimedia y respuestas de modelos documentados por EFE. Las colecciones especializadas se apoyan en `cakephp/collection`; los valores cerrados de idioma, orden y formato se representan mediante enumeraciones.

Los modelos consultables mediante `getModels()` y `getModelData()` son, en la práctica, catálogos de valores que permiten conocer los identificadores admitidos por la API. `Format` unifica el antiguo objeto de respuesta y el enum utilizado en las consultas: es un enum respaldado por enteros con los formatos conocidos (`TEXTO`, `FOTO`, `INFOGRAFIA`, `REPORTAJE`, `MULTIMEDIA`, `AUDIO`, `VIDEO`, `DOCUMENTAL`, `FICHERO` y `DIRECTOS`) y proporciona `description()` para obtener su descripción legible.

## Desarrollo y pruebas

```shell
composer test
```

Las pruebas no realizan peticiones reales: simulan las respuestas HTTP y utilizan fixtures con contenido ficticio en `tests/Fixtures/`. El directorio `tmp/` está ignorado y reservado para datos locales o privados; no forma parte del paquete distribuido.

## Estado actual

El cliente cubre únicamente Agencia EFE. No se garantiza todavía estabilidad de API pública ni compatibilidad semántica entre versiones menores.
