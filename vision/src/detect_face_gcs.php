<?php
/**
 * Copyright 2017 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

# [START face_detection_gcs]
namespace Google\Cloud\Samples\Vision;

use Google\Cloud\Vision\VisionClient;
use Google\Cloud\Storage\StorageClient;

// $projectId = 'YOUR_PROJECT_ID';
// $bucketName = 'your-bucket-name'
// $objectName = 'your-object-name'

function detect_face_gcs($projectId, $bucketName, $objectName)
{
    $vision = new VisionClient([
        'projectId' => $projectId,
    ]);
    $storage = new StorageClient([
        'projectId' => $projectId,
    ]);

    // fetch the storage object and annotate the image
    $object = $storage->bucket($bucketName)->object($objectName);
    $image = $vision->image($object, ['FACE_DETECTION']);
    $result = $vision->annotate($image);

    // print the response
    print("Faces:\n");
    foreach ((array) $result->faces() as $face) {
        printf("Anger: %s\n", $face->isAngry() ? 'yes' : 'no');
        printf("Joy: %s\n", $face->isJoyful() ? 'yes' : 'no');
        printf("Surprise: %s\n\n", $face->isSurprised() ? 'yes' : 'no');
    }
    return $result;
}
# [END face_detection_gcs]
