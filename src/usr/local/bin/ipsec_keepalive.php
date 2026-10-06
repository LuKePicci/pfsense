#!/usr/local/bin/php-cgi -q
<?php
/*
 * ipsec_keepalive.php
 *
 * part of pfSense (https://www.pfsense.org)
 * Copyright (c) 2021-2026 Rubicon Communications, LLC (Netgate)
 * All rights reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

include_once('ipsec.inc');
include_once('service-utils.inc');

/* Check if there are any tunnels defined, bail if not */
/* Check if IPsec is enabled and running, bail if disabled or stopped */
if (empty(config_get_path('ipsec/phase2')) ||
    !ipsec_enabled() ||
    !get_service_status(array('name' => 'ipsec'))) {
	if (g_get('debug')) {
		echo "IPsec is not configured and running.\n";
	}
	return false;
}

return ipsec_refresh_tunnels();
