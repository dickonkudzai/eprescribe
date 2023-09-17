package com.eprescribing.prescribe.pharmacy;

import com.eprescribing.prescribe.common.responses.ApiResponse;
import com.eprescribing.prescribe.pharmacy.data.PharmacyDto;
import com.eprescribing.prescribe.pharmacy.data.PharmacyResponse;
import com.eprescribing.prescribe.pharmacy.service.PharmacyService;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

@RestController
@RequestMapping("/api/pharmacy")
public class PharmacyController {
    private final PharmacyService pharmacyService;

    public PharmacyController(PharmacyService pharmacyService) {
        this.pharmacyService = pharmacyService;
    }
    @PostMapping("/save")
    public ResponseEntity<ApiResponse> save(@RequestBody PharmacyDto pharmacyDto){
        PharmacyResponse pharmacyResponse = this.pharmacyService.save(pharmacyDto);
        ApiResponse apiResponse = ApiResponse.builder()
                .responseCode(00)
                .message(pharmacyResponse.getMessage())
                .statusCode(pharmacyResponse.getStatusCode())
                .body(pharmacyResponse.getBody())
                .build();
        return new ResponseEntity<>(apiResponse, HttpStatus.valueOf(apiResponse.getStatusCode()));
    }

    @GetMapping("/get-all")
    public ResponseEntity<ApiResponse> getAll(){
        PharmacyResponse pharmacyResponse = this.pharmacyService.getAll();
        ApiResponse apiResponse = ApiResponse.builder()
                .body(pharmacyResponse.getBody())
                .message(pharmacyResponse.getMessage())
                .responseCode(00)
                .statusCode(pharmacyResponse.getStatusCode())
                .build();
        return new ResponseEntity<>(apiResponse, HttpStatus.valueOf(apiResponse.getStatusCode()));
    }

    @GetMapping("/find-by-id/{id}")
    public ResponseEntity<ApiResponse> findById(@PathVariable Long id){
        PharmacyResponse pharmacyResponse = this.pharmacyService.findById(id);
        ApiResponse apiResponse = ApiResponse.builder()
                .message(pharmacyResponse.getMessage())
                .statusCode(pharmacyResponse.getStatusCode())
                .body(pharmacyResponse.getBody())
                .build();
        return new ResponseEntity<>(apiResponse, HttpStatus.valueOf(apiResponse.getStatusCode()));
    }

    @PutMapping("/update-by-id/{id}")
    public ResponseEntity<ApiResponse> updateById(@PathVariable Long id, @RequestBody PharmacyDto pharmacyDto){
        PharmacyResponse pharmacyResponse = this.pharmacyService.updatebById(id, pharmacyDto);
        ApiResponse apiResponse = ApiResponse.builder()
                .message(pharmacyResponse.getMessage())
                .statusCode(pharmacyResponse.getStatusCode())
                .body(pharmacyResponse.getBody())
                .build();
        return new ResponseEntity<>(apiResponse, HttpStatus.valueOf(apiResponse.getStatusCode()));
    }

    @DeleteMapping("/delete-by-id/{id}")
    public ResponseEntity<ApiResponse> deleteById(@PathVariable Long id){
        PharmacyResponse pharmacyResponse = this.pharmacyService.deleteById(id);
        ApiResponse apiResponse = ApiResponse.builder()
                .message(pharmacyResponse.getMessage())
                .statusCode(pharmacyResponse.getStatusCode())
                .body(pharmacyResponse.getBody())
                .build();
        return new ResponseEntity<>(apiResponse, HttpStatus.valueOf(apiResponse.getStatusCode()));
    }
}
