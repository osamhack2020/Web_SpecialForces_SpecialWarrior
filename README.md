# SpecialForces
![Logo](https://logosbynick.com/wp-content/uploads/2018/03/final-logo-example.png)</br>
SpecialForces is a healthcare solution for Ministry of National Defense Soldiers.</br>
스페셜포스는 대한민국 국방부 국군 장병들을 위한 헬스케어 솔루션입니다.

[![GitHub forks](https://img.shields.io/github/forks/osamhack2020/Web_SpecialForces_SpecialWarrior?style=for-the-badge)](https://github.com/osamhack2020/Web_SpecialForces_SpecialWarrior/network)
[![GitHub stars](https://img.shields.io/github/stars/osamhack2020/Web_SpecialForces_SpecialWarrior?style=for-the-badge)](https://github.com/osamhack2020/Web_SpecialForces_SpecialWarrior/stargazers)
[![GitHub license](https://img.shields.io/github/license/osamhack2020/Web_SpecialForces_SpecialWarrior?style=for-the-badge)](https://github.com/osamhack2020/Web_SpecialForces_SpecialWarrior/blob/main/LICENSE)

[![API DOCUMENT](https://img.shields.io/badge/API%20DOCUMENT-LINK-green?style=for-the-badge)](https://spefo.stoplight.io/docs/web-specialforces-specialwarrior/reference/specialforces.v1.yaml)

[![DEMO](https://img.shields.io/badge/Live%20Demo-LINK-green?style=for-the-badge)](https://page.spefor.ml)<br>
- Test account for Demo<br>
    <table>
    <thead>
        <tr>
            <td>ID</td>
            <td>PW</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>test</td>
            <td>test</td>
        </tr>
    </tbody>
    </table>

## 1. Intro (팀소개 및 프로잭트 설명 동영상)
[![Watch the video](https://img.youtube.com/vi/LjX3eVQdIyk/0.jpg)](https://www.youtube.com/watch?time_continue=117&v=LjX3eVQdIyk)</br>
>The project SpecialForces was done by team SpecialWarriors. The team consist of IoT developer(Project Manager), App developer and Web developer. Web developer also developed the server.

>스페셜포스 프로젝트는 특급전사 팀에 의해 만들어졌습니다. 특급전사는 IoT개발자(Project Manager), App개발자, Web개발자로 이루어져 있으며 PM은 IoT 디바이스 개발, Web개발자는 백오피스 및 서버를 개발하였습니다.<br><br>
스페셜포스는 장병들의 운동을 기록해주는 디바이스와 이를 한 눈에 보여주는 
어플리케이션 그리고 관리를 할 수 있는 웹사이트로 이루어져 있습니다.

### (1)Service
>스페셜포스 디바이스는 장병들의 체력을 자동으로 측정해주는 장치입니다. 해당 장치는 여러개의 모듈로 이루어져 있으며 이 모듈이 각각의 운동 내역을 어플리케이션에 NFC 통신으로 기록합니다. 장병들은 자신의 운동기록을 어플리케이션을 통해 확인 할 수 있으며 체력 측정기록, 심박동 측정기록, 수면기록도 확인 및 관리 할 수 있습니다. 또한 전우들과 자신의 운동량을 비교해 볼수도 있습니다. 체력 측정기록은 국방부 체력검정 기준을 따릅니다.

>The IoT devices was designed to record fitness data automatically. The device consist of some modules that record and transmit fitness data to Android application through NFC technology. Soldiers can monitor their records via Android application and also heartrate data, sleep pattern data, fitness test data that according to MND(Ministry of National Defense) creteria.

### (2)Management
>스페셜포스의 웹사이트는 병사들을 관리하는 간부 전용입니다. 스페셜포스 솔루션이 있다면 간부들은 병사들의 운동, 수면시간, 심박도, 체중, 신장 등 신체 정보를 확인하여 병사들의 건강관리를 할 수 있습니다. 이 관리 페이지는 병사들에게 자율적인 운동과 자기관리를 권장하면서도 효율적으로 병사들의 건강상태를 파악할 수 있게 합니다.

>The website for SpecialForce is just for cadre that supervise soldiers. With SpecialForces, Supervisors are able to take care of exercise, sleep time, heartrate, weight and height of soldiers. Supervisors can monitor health statement for their soldiers while encouraging soldiers to do fitness and care themselves autonomously, too.

## 2. StoryBoard (기능설계)
- <a href = "https://docs.google.com/presentation/d/1y2Pu0RgSUVKd3x4ULOtYEjo13R1m0j6FjGWLmiCoR_Y/edit?usp=sharing"> Web/App화면설계안 </a>
- <a href = "https://github.com/orgs/SpecailForces/projects/1"> git project KanBanBoard 1 </a>
- <a href = "https://github.com/osamhack2020/App_SpecialForces_SpecialWarrior/projects/2"> git project KanBanBoard 2 </a>
- <a href = "https://calendar.google.com/calendar/u/0?cid=OG1yZ3FhYTI5MTMwN2FldTZucDdvbXEwcmNAZ3JvdXAuY2FsZW5kYXIuZ29vZ2xlLmNvbQ"> Google Calendar 특급전사 팀 공개 일정 </a>
- <a href = "https://www.erdcloud.com/d/x3pmnS3jFMrxiPcaW"> DB ERD </a>

## 3. Prerequisites (컴퓨터구성/필수조건 안내)
- 안드로이드 버전

- 웹브라우저 제한사항
    - Chrome 62 이상
    - IE 9,10,11 (IE 8 이하 미지원)
    - Edge 15 이상
    - Firefox 56 이상
    - Safari 8 이상

- 아두이노 장치 구성


## 4. Technique Used (기술스택)
### (1)Back Office
    vuejs
    vue-cli
    vuetifyjs
    vue-router
    vuex
    axios
### (2)Application

### (3)Server
    PHP 7.2
    MariaDB 10.1
    Apache 2.4
### (4)IoT Device(클릭시 해당 기기 문서로 이동)
- <a href = "https://github.com/SpecailForces/SpecialForces-IoT/tree/master/devices/push_up#specialforces-push-up-auto-measuring-device">팔굽혀펴기 체력 측정장치</a>
- <a href = "https://github.com/SpecailForces/SpecialForces-IoT/tree/master/devices/sit_up#specialforces-sit-up-auto-measuring-device">윗몸일으키기 체력 측정장치</a>
- <a href = "https://github.com/SpecailForces/SpecialForces-IoT/tree/master/devices/run#specialforces-running-auto-measuring-device">뜀뛰기 체력 측정장치</a>
- <a href = "https://github.com/SpecailForces/SpecialForces-IoT/tree/master/devices/lat_pull_down#specialforces-lat-pull-down-auto-measuring-device">렛 폴 다운 운동 측정장치</a>
- <a href = "https://github.com/SpecailForces/SpecialForces-IoT/tree/master/devices/leg_press#specialforces-leg-press-auto-measuring-device">레그 프레스 운동 측정장치</a>

## 5. Installation Process (설치 안내)

### app

### IoT(클릭시 해당 기기 문서로 이동)
- <a href = "https://github.com/SpecailForces/SpecialForces-IoT/tree/master/devices/push_up#installation-process-%EC%84%A4%EC%B9%98-%EC%95%88%EB%82%B4">팔굽혀펴기 체력 측정장치</a>
- <a href = "https://github.com/SpecailForces/SpecialForces-IoT/tree/master/devices/sit_up#installation-process-%EC%84%A4%EC%B9%98-%EC%95%88%EB%82%B4">윗몸일으키기 체력 측정장치</a>
- <a href = "https://github.com/SpecailForces/SpecialForces-IoT/tree/master/devices/run#installation-process-%EC%84%A4%EC%B9%98-%EC%95%88%EB%82%B4">뜀뛰기 체력 측정장치</a>
- <a href = "https://github.com/SpecailForces/SpecialForces-IoT/tree/master/devices/lat_pull_down#installation-process-%EC%84%A4%EC%B9%98-%EC%95%88%EB%82%B4">렛 폴 다운 운동 측정장치</a>
- <a href = "https://github.com/SpecailForces/SpecialForces-IoT/tree/master/devices/leg_press#installation-process-%EC%84%A4%EC%B9%98-%EC%95%88%EB%82%B4">레그 프레스 운동 측정장치</a>

## 6. Getting Started (프로젝트 사용법)
### app
<병사용 Service>


### IoT
<운동기구>
1. 하고 싶은 운동기구에 헨드폰을 올려 둔다.
2. 운동을 시작한다.
3. 어플리케이션에 해당 운동 내역이 자동으로 저장된다.

<체력 측정 기구>
1. 측정하고 싶은 운동기구에 헨드폰을 올려 둔다.
2. 버튼을 누른다.
3. 부저의 알람이 울릴 때까지 운동을 실시한다.
4. 시간과 운동 현황은 운동기구에 달려있는 LCD를 통해 볼 수 있다.
5. 부저가 울리면 어플리케이션에 결과가 자동으로 측정된다.

### web

<간부용 BackOffice>

1. <a href = "https://osamhack2020.github.io/Web_SpecialForces_SpecialWarrior
"> 해당 사이트 </a> 접속
2. 부대 소속 및 군번 개인정보 입력 후 회원가입
3. 병사관리 텝에서 병사들의 건강상테 리스트를 볼 수 있으며 클릭시 상세 보기가 주어짐.
4. 모아보기 페이지는 모든 병사들의 운동별 현황을 그래프를 통해 한 번에 파악 가능.
5. 병사현황 페이지를 이용하면 특급전사 및 체력측정 기준에 합격자 인원을 쉽게 파악할 수 있음.
6. FAQ를 통해 Back Office의 모르는 사항을 빠르게 찾아볼 수 있음.
7. 공지사항 페이지에서 공지를 만들어서 병사들이 사용하는 어플리케이션에 공지를 보낼 수 있음.


## 7. Team Information (팀 정보)
- <b>PM & IoT</b> Park SungSoo (skyinbss@gmail.com), Github Id: <a href = "https://github.com/Moerai">KrToTo</a>
- <b>Web & Server</b> Park SeongCheol (gorae02@gmail.com), Github Id: <a href = "https://github.com/goraegori">goraegori</a>
- <b>Application</b> Kang Chan (koxx1107@gmail.com), Github Id: <a href = "https://github.com/LieutenantKang">Lieutenant Kang</a>

## 8. Copyleft / End User License(저작권 및 사용권 정보)
This work is dual-licensed under * [MIT](https://github.com/SpecailForces/SpecialForces-IoT/blob/master/MIT_license.md) AND * [Apache License 2.0](https://github.com/SpecailForces/SpecialForces-IoT/blob/master/Apache_license.md).</br>
You must comply with all this licenses if you use this work.</br>



//SpecialForces Organization으로 되어 있는 URL 모두 편집할 것!!
