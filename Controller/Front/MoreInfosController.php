<?php
/*************************************************************************************/
/*                                                                                   */
/*      Thelia                                                                       */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : info@thelia.net                                                      */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      This program is free software; you can redistribute it and/or modify         */
/*      it under the terms of the GNU General Public License as published by         */
/*      the Free Software Foundation; either version 3 of the License                */
/*                                                                                   */
/*      This program is distributed in the hope that it will be useful,              */
/*      but WITHOUT ANY WARRANTY; without even the implied warranty of               */
/*      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                */
/*      GNU General Public License for more details.                                 */
/*                                                                                   */
/*      You should have received a copy of the GNU General Public License            */
/*      along with this program. If not, see <http://www.gnu.org/licenses/>.         */
/*                                                                                   */
/*************************************************************************************/

namespace MoreInfos\Controller\Front;

use MoreInfos\Form\MoreInfosForm;
use Thelia\Controller\Front\BaseFrontController;
use Thelia\Core\Translation\Translator;
use Thelia\Form\Exception\FormValidationException;
use Thelia\Model\ConfigQuery;

/**
 * Class MoreInfosController
 * @package MoreInfos\Controller\Front
 * @author Michaël Espeche <mespeche@openstudio.fr>
 */
class MoreInfosController extends BaseFrontController {


    public function send() {

        $error_message = false;
        $contactForm = new MoreInfosForm($this->getRequest());

        try {
            $form = $this->validateForm($contactForm);

            $message = \Swift_Message::newInstance(Translator::getInstance()->trans('A request for additional information was sent : ', array(), 'moreinfos') . $form->get('product')->getData())
                ->addFrom($form->get('email')->getData())
                ->addTo(ConfigQuery::read('moreinfos-email'), ConfigQuery::read('store_name'))
                ->setBody($form->get('message')->getData())
            ;

            $this->getMailer()->send($message);

        } catch (FormValidationException $e) {
            $error_message = $e->getMessage();
        }

        if ($error_message !== false) {
            \Thelia\Log\Tlog::getInstance()->error(sprintf('Error during sending mail : %s', $error_message));

            $contactForm->setErrorMessage($error_message);

            $this->getParserContext()
                ->addForm($contactForm)
                ->setGeneralError($error_message)
            ;

            $this->redirect('/');

        } else {
            $this->redirect($form->get('return_url')->getData() . '&moreinfos_success=1');
        }

    }

} 