; $Id$
;
; Makes the AEEDIRP web site
;

api = 2

; Core version
; ------------

core = 6.x

; Core project
; ------------

projects[drupal][type] = "core"

; Modules
; -------

projects[] = cck
projects[] = link
projects[] = filefield
projects[] = imagefield
projects[views][version] = 3.0-alpha3
projects[] = rules
projects[] = swftools
projects[] = workflow
projects[] = globalredirect
projects[] = token
projects[] = pathauto
projects[] = google_analytics
projects[] = menu_breadcrumb
projects[] = date
projects[] = advanced_help
projects[] = node_import
projects[] = node_export
projects[] = features

; Themes
; ------

projects[] = nitobe