# dolibarr-takepos-movil

Módulo de Dolibarr que rediseña la interfaz del TPV móvil (**TakePOS**) para mejorar la usabilidad en dispositivos pequeños: layout compacto, selección de mesa mejorada, cabeceras limpias y correcciones de comportamiento en AJAX.

## Stack

![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat&logo=php&logoColor=white)
![Dolibarr](https://img.shields.io/badge/Dolibarr-ERP-informational)
![Docker](https://img.shields.io/badge/Docker-2496ED?style=flat&logo=docker&logoColor=white)

## Compatibilidad

Probado con Dolibarr 16 (ver `docker-compose.yml`).

## Qué hace

- Override CSS de la página de teléfono de TakePOS
- Mejora de la selección y ordenación de mesas/lugares
- Cabeceras más compactas y botón de retroceso funcional
- Corrección de errores de SyntaxError en recargas AJAX
- Protección del botón PED durante operaciones en curso

## Puesta en marcha

```bash
docker compose up -d
```

Acceder a [http://localhost:8080](http://localhost:8080). Activar el módulo `takeposphonefix` desde **Configuración → Módulos**.

## Estructura

```
takeposphonefix/
  ajax/         # Sobreescritura del endpoint de lugares
  class/        # Hook de acciones del módulo
  core/modules/ # Definición del módulo
  css/          # Overrides CSS para la vista de teléfono
docker-compose.yml
```

## Licencia

GPL-3.0-or-later. Ver [LICENSE](LICENSE).

## Autor

Javier Muñoz Solano — C3i Servicios Informáticos, C.B.

