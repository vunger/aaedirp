; $Id$
;
; Makes the AEEDIRP web site (I hope!)
;

api = 2

; Core version
; ------------

core = 6.x

; Core project
; ------------

projects[drupal][type] = "core"

; Projects
; --------

projects[] = cck
projects[views][version] = 3.0-alpha3
projects[] = rules
projects[] = swftools
; projects[] = workflow
projects[] = globalredirect
projects[] = token
projects[] = pathauto
projects[] = google_analytics
projects[] = node_import
projects[] = features