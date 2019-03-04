<?php

namespace enovate\dolphiqredirectsimport\controllers;

use craft\records\Element;
use craft\records\Element_SiteSettings;
use craft\web\Controller;
use craft\web\UploadedFile;
use dolphiq\redirect\elements\Redirect;

class DolphiqRedirectsImportController extends Controller
{
    protected $allowAnonymous = true;

    public function actionImport()
    {

        $upload = UploadedFile::getInstanceByName('file');

        $file = fopen($upload->tempName, 'r');

        $headers = fgetcsv($file, 1000, "\t"); // TODO: Custom mapping?

        while (($line = fgetcsv($file, 1000, "\t")) != false) {


            $sourceUrl = $line[1];
            $destinationUrl = $line[2];
            $statusCode = $line[3];
            $dateCreated = $line[4];
            $dateUpdated = $line[5];
            $uid = $line[6];

            $sourceUrl = htmlentities($sourceUrl);

            $element_type = Redirect::class;

            $element = new Element();
            $element->type = $element_type;
            $element->save();

            $element_site = new Element_SiteSettings();
            $element_site->elementId = $element->id;
            $element_site->siteId = 1;
            $element_site->enabled = 1;
            $element_site->save();


            $redirect = new \dolphiq\redirect\records\Redirect();
            $redirect->sourceUrl = $sourceUrl;
            $redirect->destinationUrl = $destinationUrl;
            $redirect->statusCode = $statusCode;
            $redirect->id = $element->id;

            $redirect->save();

        }

        return $this->redirect('/admin/dolphiqredirectsimport');
    }

}